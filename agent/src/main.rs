mod api;
mod job_processor;
mod progress;
mod queue;
mod worker;

use tokio::signal;
use worker::Worker;

#[tokio::main]
async fn main() {
    let mut worker = Worker::new();

    worker.spawn().await;

    signal::ctrl_c()
        .await
        .expect("Couldn't listen for shutdown signal");

    worker.shutdown().await.expect("Couldn't shutdown worker");
}
