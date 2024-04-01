mod api;
mod job_processor;
mod progress;
mod queue;

use job_processor::JobProcessor;
use progress::ProgressManager;
use queue::Queue;
use std::time::Duration;
use tokio::signal;
use tokio_util::{sync::CancellationToken, task::TaskTracker};

#[tokio::main]
async fn main() {
    let tracker = TaskTracker::new();
    let cancellation_token = CancellationToken::new();
    let queue = Queue::new(tracker.clone(), cancellation_token.clone());
    let progress = ProgressManager::new();

    loop {
        let queue = queue.clone();
        let progress = progress.clone();
        let cancellation_token = cancellation_token.clone();
        tokio::select! {
            job = queue.next() => {
                match job {
                    Ok(job) => {
                        match job {
                            Some(job) => {
                                tracker.spawn(async move {
                                    let processor = JobProcessor::new(queue, progress);
                                    processor.handle(job).await.expect("Could not process job");
                                });
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
            _ = signal::ctrl_c() => {
                // println!("Gracefully shutting down...");
                progress.start_shutdown().await.expect("Unable to start shutdown progress");
                tracker.close();
                cancellation_token.cancel();
                break;
            },
        }
    }

    tracker.wait().await;

    progress
        .finish_shutdown()
        .await
        .expect("Unable to finish shutdown progress");
}
