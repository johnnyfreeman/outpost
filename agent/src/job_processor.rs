use crate::api::PipelineJob;
use crate::progress::ProgressManager;
use crate::queue::Queue;
use anyhow::Result;
use chrono::Utc;
use std::process::Stdio;
use tokio::io::{AsyncBufReadExt, BufReader};

pub struct JobProcessor {
    queue: Queue,
    progress: ProgressManager,
}

impl JobProcessor {
    pub fn new(queue: Queue, progress: ProgressManager) -> Self {
        Self { queue, progress }
    }

    pub async fn handle(&self, mut job: PipelineJob) -> Result<()> {
        self.progress.start(job.clone()).await?;

        job.started_at = Some(Utc::now());

        for line in job.step.script.clone().lines() {
            if let Some((command, args)) =
                line.split_whitespace().collect::<Vec<&str>>().split_first()
            {
                let output = tokio::process::Command::new(command)
                    .args(args)
                    .output()
                    .await?;

                job.append_output(&String::from_utf8(output.stdout)?);
                job.append_output(&String::from_utf8(output.stderr)?);

                match output.status.code() {
                    Some(code) => match code {
                        0 => {
                            job.exit_code = output.status.code();

                            self.progress.success(job.clone()).await?;
                        }
                        code => {
                            job.exit_code = Some(code);

                            self.progress.fail(job.clone()).await?;
                        }
                    },
                    None => {
                        job.exit_code = None;

                        self.progress.terminate(job.clone()).await?;
                    }
                let mut command = tokio::process::Command::new(command);
                command.args(args);
                if let Some(path) = &self.job.step.current_directory {
                    command.current_dir(tokio::fs::canonicalize(path).await?);
                }
                let output = command.output().await?;

                if self.queue.update(job.clone()).await.is_err() {
                    eprintln!("Failed to send output line");
                    break;
                }
            }
        }
        // let mut child = tokio::process::Command::new("sh")
        //     .arg("-c")
        //     .arg(&job.step.script.clone())
        //     .stdout(Stdio::piped())
        //     .stderr(Stdio::piped())
        //     .spawn()?;

        // if let Some(stdout) = child.stdout.take() {
        //     let mut lines = BufReader::new(stdout).lines();
        //     while let Some(line) = lines.next_line().await? {
        //         job.append_output(&line);

        //         if self.queue.update(*job.clone()).await.is_err() {
        //             eprintln!("Failed to send output line");
        //             break;
        //         }
        //     }
        // }

        // if let Some(stderr) = child.stderr.take() {
        //     let mut lines = BufReader::new(stderr).lines();
        //     while let Some(line) = lines.next_line().await? {
        //         job.append_output(&line);

        //         if self.queue.update(*job.clone()).await.is_err() {
        //             eprintln!("Failed to send output line");
        //             break;
        //         }
        //     }
        // }
        eprintln!("Output: {:?}", job);

        // let output = child.wait_with_output().await?;
        job.finished_at = Some(Utc::now());

        if self.queue.update(job.clone()).await.is_err() {
            eprintln!("Failed to send output line");
        }

        Ok(())
    }
}
