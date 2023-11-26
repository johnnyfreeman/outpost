mod api;
mod progress;

use api::{Api, ApiAction, PipelineJob, PipelineJobResponse};
use chrono::Utc;
use progress::initialize_progress_bars;
use progress::Progress;
use reqwest::StatusCode;
use std::process::Stdio;
use tokio::io::{AsyncBufReadExt, BufReader};
use tokio::spawn;
use tokio::sync::mpsc::Sender;
use tokio::sync::{mpsc, oneshot};

#[tokio::main]
async fn main() {
    let (tx, mut rx) = mpsc::channel(32);
    spawn(async move {
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
                    api.update_job(*job).await.expect("Could not update job");
                }
            }
        }
    });

    let progress = initialize_progress_bars();

    loop {
        let tx = tx.clone();
        let progress = progress.clone();

        let (resp_tx, resp_rx) = oneshot::channel();

        tx.send(ApiAction::GetNextPipelineJob { tx: resp_tx })
            .await
            .expect("Could not send ApiAction::GetNextPipelineJob");

        if let Some(job) = resp_rx.await.expect("Could not receive next job") {
            spawn(async move {
                process_job(job, tx, progress).await;
            });
        }
    }
}

async fn process_job(job: PipelineJob, tx: mpsc::Sender<ApiAction>, progress: Sender<Progress>) {
    let mut job = Box::new(job);

    progress
        .send(Progress::Start(*job.clone()))
        .await
        .expect("Cound not start progress bar");

    job.started_at = Some(Utc::now());

    let mut child = tokio::process::Command::new("sh")
        .arg("-c")
        .arg(&job.step.script.clone())
        .stdout(Stdio::piped())
        .stderr(Stdio::piped())
        .spawn()
        .expect("Failed to execute command");

    if let Some(stdout) = child.stdout.take() {
        let mut lines = BufReader::new(stdout).lines();
        while let Some(line) = lines.next_line().await.unwrap() {
            job.append_output(&line);

            if tx
                .send(ApiAction::UpdatePipelineJob(job.clone()))
                .await
                .is_err()
            {
                eprintln!("Failed to send output line");
                break;
            }
        }
    }

    if let Some(stderr) = child.stderr.take() {
        let mut lines = BufReader::new(stderr).lines();
        while let Some(line) = lines.next_line().await.unwrap() {
            job.append_output(&line);

            if tx
                .send(ApiAction::UpdatePipelineJob(job.clone()))
                .await
                .is_err()
            {
                eprintln!("Failed to send output line");
                break;
            }
        }
    }

    let output = child.wait_with_output().await.unwrap();
    job.finished_at = Some(Utc::now());

    match output.status.code() {
        Some(code) => match code {
            0 => {
                job.exit_code = output.status.code();

                progress
                    .send(Progress::Succeed(*job.clone()))
                    .await
                    .expect("Cound not mark progress bar as succeeded");
            }
            code => {
                job.exit_code = Some(code);

                progress
                    .send(Progress::Fail(*job.clone()))
                    .await
                    .expect("Cound not mark progress bar as failed");
            }
        },
        None => {
            job.exit_code = None;

            progress
                .send(Progress::Terminate(*job.clone()))
                .await
                .expect("Cound not mark progress bar as terminated");
        }
    }

    if tx
        .send(ApiAction::UpdatePipelineJob(job.clone()))
        .await
        .is_err()
    {
        eprintln!("Failed to send output line");
    }
}
