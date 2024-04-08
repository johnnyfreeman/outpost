use crate::{
    api::PipelineJob, job_processor::JobProcessor, progress::ProgressManager, queue::Queue,
};
use anyhow::Result;
use std::time::Duration;
use tokio::task::JoinHandle;
use tokio_util::{sync::CancellationToken, task::TaskTracker};

pub struct Worker {
    queue: Queue,
    tracker: TaskTracker,
    progress: ProgressManager,
    cancellation_token: CancellationToken,
}

impl Worker {
    pub fn new() -> Self {
        let cancellation_token = CancellationToken::new();
        let tracker = TaskTracker::new();
        let queue = Queue::new();
        let progress = ProgressManager::new();

        Self {
            queue,
            tracker,
            progress,
            cancellation_token,
        }
    }

    pub async fn spawn(&mut self) -> JoinHandle<()> {
        let mut queue = self.queue.clone();
        let progress = self.progress.clone();
        let tracker = self.tracker.clone();
        let cancellation_token = self.cancellation_token.child_token();

        let _handle = queue.spawn();

        self.tracker.spawn(async move {
            loop {
                let queue = queue.clone();

                tokio::select! {
                    job = queue.next() => {
                        match job {
                            Ok(job) => {
                                match job {
                                    Some(job) => {
                                        let progress = progress.clone();
                                        let tracker = tracker.clone();

                                        tracker.spawn(process_job(queue, job, progress));
                                    }
                                    None => {
                                        tokio::time::sleep(Duration::from_secs(3)).await;
                                    }
                                }
                            }
                            Err(err) => {
                                eprintln!("Queue failed getting next job: {}", err);
                            }
                        }
                    },
                    _ = cancellation_token.cancelled() => {
                        return;
                    },
                }
            }
        })
    }

    pub async fn shutdown(&self) -> Result<()> {
        self.progress.start_shutdown().await?;
        self.tracker.close();
        self.cancellation_token.cancel();
        self.tracker.wait().await;
        self.queue.shutdown().await?;
        self.progress.finish_shutdown().await?;
        Ok(())
    }
}

async fn process_job(queue: Queue, job: PipelineJob, progress: ProgressManager) -> Result<()> {
    progress.start(job.clone()).await?;
    let mut processor = JobProcessor::new(job.clone(), queue.clone());
    match processor.handle().await {
        Ok(code) => match code {
            Some(code) => match code {
                0 => {
                    progress.success(processor.job.clone()).await?;
                }
                _error_code => {
                    progress.fail(processor.job.clone()).await?;
                }
            },
            None => {
                progress.terminate(processor.job.clone()).await?;
            }
        },
        Err(error) => {
            processor.failed(error).await?;
            progress.fail(job.clone()).await?;
        }
    }
    Ok(())
}
