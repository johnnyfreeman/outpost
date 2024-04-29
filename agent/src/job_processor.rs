use crate::api::PipelineJob;
use crate::queue::Queue;
use anyhow::{Error, Result};
use chrono::Utc;
// use std::process::Stdio;
// use tokio::io::{AsyncBufReadExt, BufReader};

pub struct JobProcessor {
    pub job: PipelineJob,
    queue: Queue,
}

impl JobProcessor {
    pub fn new(job: PipelineJob, queue: Queue) -> Self {
        Self { job, queue }
    }

    pub async fn handle(&mut self) -> Result<Option<i32>> {
        self.job.started_at = Some(Utc::now());
        self.queue.update(self.job.clone()).await?;

        for line in self.job.step.script.clone().lines() {
            if let Some((command, args)) =
                line.split_whitespace().collect::<Vec<&str>>().split_first()
            {
                let mut command = tokio::process::Command::new(command);
                command.args(args);
                if let Some(path) = &self.job.step.current_directory {
                    command.current_dir(tokio::fs::canonicalize(path).await?);
                }
                let output = command.output().await?;

                self.job.append_output(&String::from_utf8(output.stdout)?);
                self.job.append_output(&String::from_utf8(output.stderr)?);
                self.job.exit_code = output.status.code();
                self.queue.update(self.job.clone()).await?;
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

        // let output = child.wait_with_output().await?;
        self.job.finished_at = Some(Utc::now());
        self.queue.update(self.job.clone()).await?;

        Ok(self.job.exit_code)
    }

    pub async fn failed(&mut self, error: Error) -> Result<()> {
        self.job.append_output(&error.to_string());
        self.job.exit_code = Some(1);
        self.job.finished_at = Some(Utc::now());
        self.queue.update(self.job.clone()).await?;
        Ok(())
    }
}
