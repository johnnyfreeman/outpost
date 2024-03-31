mod api;
mod job_processor;
mod progress;
mod queue;

use job_processor::JobProcessor;
use progress::ProgressManager;
use queue::Queue;

#[tokio::main]
async fn main() {
    let queue = Queue::new();
    let progress = ProgressManager::new();

    loop {
        let queue = queue.clone();
        let progress = progress.clone();
        match queue.next().await {
            Ok(job) => {
                if let Some(job) = job {
                    tokio::spawn(async move {
                        let processor = JobProcessor::new(queue, progress);
                        processor.handle(job).await.expect("Could not process job");
                    });
                }
            }
            Err(err) => {
                eprintln!("Queue failed getting next job");
            }
        }
    }
}
