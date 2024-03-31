use std::sync::Arc;

use crate::api::{Api, ApiAction, PipelineJob, PipelineJobResponse};
use anyhow::Result;
use reqwest::StatusCode;
use tokio::{
    sync::{
        mpsc::{self, Sender},
        oneshot,
    },
    task::JoinHandle,
};

#[derive(Clone)]
pub struct Queue {
    tx: Sender<ApiAction>,
    handle: Arc<JoinHandle<()>>,
}

impl Queue {
    pub fn new() -> Self {
        let (tx, mut rx) = mpsc::channel(32);

        let handle = tokio::spawn(async move {
            let mut api = Api::new().expect("Could not instantiate API");

            while let Some(action) = rx.recv().await {
                match action {
                    ApiAction::GetNextPipelineJob { tx } => {
                        let response = api
                            .get_next_job()
                            .await
                            .expect("Could not retrieve next job");

                        match response.status() {
                            StatusCode::OK => {
                                tx.send(
                                    response
                                        .json::<PipelineJobResponse>()
                                        .await
                                        .expect("Could not transform json into PipelineJobResponse")
                                        .data,
                                )
                                .expect("Could not send next job back");
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
        });

        Self {
            tx,
            handle: Arc::new(handle),
        }
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
