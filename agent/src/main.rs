mod api;
mod progress;
mod queue;

use anyhow::Result;
use api::PipelineJob;
use chrono::Utc;
use progress::ProgressManager;
use queue::Queue;
use std::process::Stdio;
use tokio::io::{AsyncBufReadExt, BufReader};

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
                        process_job(job, queue, progress)
                            .await
                            .expect("Could not process job");
                    });
                }
            }
            Err(err) => {
                eprintln!("Queue failed getting next job");
            }
        }
    }
}

async fn process_job(job: PipelineJob, queue: Queue, progress: ProgressManager) -> Result<()> {
    let mut job = Box::new(job);

    progress.start(*job.clone()).await?;

    job.started_at = Some(Utc::now());

    let mut child = tokio::process::Command::new("sh")
        .arg("-c")
        .arg(&job.step.script.clone())
        .stdout(Stdio::piped())
        .stderr(Stdio::piped())
        .spawn()?;

    if let Some(stdout) = child.stdout.take() {
        let mut lines = BufReader::new(stdout).lines();
        while let Some(line) = lines.next_line().await? {
            job.append_output(&line);

            if queue.update(*job.clone()).await.is_err() {
                eprintln!("Failed to send output line");
                break;
            }
        }
    }

    if let Some(stderr) = child.stderr.take() {
        let mut lines = BufReader::new(stderr).lines();
        while let Some(line) = lines.next_line().await? {
            job.append_output(&line);

            if queue.update(*job.clone()).await.is_err() {
                eprintln!("Failed to send output line");
                break;
            }
        }
    }

    let output = child.wait_with_output().await?;
    job.finished_at = Some(Utc::now());

    match output.status.code() {
        Some(code) => match code {
            0 => {
                job.exit_code = output.status.code();

                progress.success(*job.clone()).await?;
            }
            code => {
                job.exit_code = Some(code);

                progress.fail(*job.clone()).await?;
            }
        },
        None => {
            job.exit_code = None;

            progress.terminate(*job.clone()).await?;
        }
    }

    if queue.update(*job.clone()).await.is_err() {
        eprintln!("Failed to send output line");
    }

    Ok(())
}
