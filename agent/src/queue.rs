use crate::api::{Api, ApiAction, PipelineJob, PipelineJobResponse};
use anyhow::Result;
use reqwest::StatusCode;
use tokio::sync::{
    mpsc::{self, Sender},
    oneshot,
};
use tokio_util::{sync::CancellationToken, task::TaskTracker};

#[derive(Clone)]
pub struct Queue {
    tx: Sender<ApiAction>,
}

impl Queue {
    pub fn new(tracker: TaskTracker, cancellation_token: CancellationToken) -> Self {
        let (tx, mut rx) = mpsc::channel(32);

        tracker.spawn(async move {
            let mut api = Api::new().expect("Could not instantiate API");

            loop {
                tokio::select! {
                    Some(action) = rx.recv() => {
                        match action {
                            ApiAction::GetNextPipelineJob { tx } => {
                                let response = api
                                    .get_next_job()
                                    .await
                                    .expect("Could not retrieve next job");

                                match response.status() {
                                    StatusCode::OK => {
                                        if let Err(job) = tx.send(response
                                            .json::<PipelineJobResponse>()
                                            .await
                                            .expect("Could not transform json into PipelineJobResponse")
                                            .data) {
                                            // println!("Could not send Option<PipelineJob> back through the channel");
                                            match job {
                                                Some(mut job) => {
                                                    job.reserved_at = None;
                                                    api.update_job(job).await.expect("Could not release job back onto the queue");
                                                    // println!("Released the job back onto the queue");
                                                }
                                                None => {
                                                    // println!("No need to release any job back onto the queue");
                                                }
                                            }
                                        }
                                    }
                                    StatusCode::UNAUTHORIZED => {
                                        api.refresh_token().await.expect("Could not refresh token");
                                        tx.send(None).expect("Could not send next job back");
                                    }
                                    _ => {
                                        tx.send(None).expect("Could not send next job back");
                                    }
                                }
                            }
                            ApiAction::UpdatePipelineJob(job) => {
                                api.update_job(job).await.expect("Could not update job");
                            }
                        }
                    }
                    _ = cancellation_token.cancelled() => {
                        // println!("Shutting down queue...");
                        break;
                    }
                }
            }

            // println!("Queue has been shutdown");
        });

        Self { tx }
    }

    pub async fn next(&self) -> Result<Option<PipelineJob>> {
        let (resp_tx, resp_rx) = oneshot::channel();

        self.tx
            .send(ApiAction::GetNextPipelineJob { tx: resp_tx })
            .await?;

        Ok(resp_rx.await?)
    }

    pub async fn update(&self, job: PipelineJob) -> Result<()> {
        self.tx.send(ApiAction::UpdatePipelineJob(job)).await?;

        Ok(())
    }
}