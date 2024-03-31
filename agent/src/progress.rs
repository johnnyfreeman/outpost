use crate::api::PipelineJob;
use anyhow::Result;
use console::style;
use indicatif::{MultiProgress, ProgressBar, ProgressStyle};
use std::collections::BTreeMap;
use tokio::sync::mpsc;
use tokio::sync::mpsc::Sender;
use tokio::time::Duration;

pub enum Progress {
    Start(PipelineJob),
    Succeed(PipelineJob),
    Fail(PipelineJob),
    Terminate(PipelineJob),
    ShutdownStart,
    ShutdownFinish,
}

#[derive(Clone)]
pub struct ProgressManager {
    tx: Sender<Progress>,
}

impl ProgressManager {
    pub fn new() -> Self {
        let (tx, mut rx) = mpsc::channel(32);

        tokio::spawn(async move {
            let multiprogress = MultiProgress::new();

            let spinner_style =
                ProgressStyle::with_template("{prefix:.bold.dim} {spinner} {wide_msg}").unwrap();

            let mut map: BTreeMap<String, ProgressBar> = BTreeMap::new();

            while let Some(action) = rx.recv().await {
                match action {
                    Progress::Start(job) => {
                        let progress = multiprogress.add(ProgressBar::new_spinner());
                        progress.enable_steady_tick(Duration::from_millis(64));
                        progress.set_style(spinner_style.clone());
                        progress.set_prefix(job.id.clone());
                        progress.set_message(job.step.name.clone());
                        map.insert(job.id, progress.clone());
                    }
                    Progress::Succeed(job) => {
                        multiprogress
                            .println(&format!(
                                "{} {} {}",
                                style(&job.id).bold().dim(),
                                style("✓").green(),
                                &job.step.name,
                            ))
                            .expect("Could not print line");
                        let progress = map.get(&job.id).expect("Count not find ProgressBar");
                        progress.finish_and_clear();
                        multiprogress.remove(progress);
                        map.remove(&job.id);
                    }
                    Progress::Fail(job) => {
                        multiprogress
                            .println(&format!(
                                "{} {} {}",
                                style(&job.id).bold().dim(),
                                style("✗").red(),
                                &job.step.name,
                            ))
                            .expect("Could not print line");
                        let progress = map.get(&job.id).expect("Count not find ProgressBar");
                        progress.finish_and_clear();
                        multiprogress.remove(progress);
                        map.remove(&job.id);
                    }
                    Progress::Terminate(job) => {
                        multiprogress
                            .println(&format!(
                                "{} {} {}",
                                style(&job.id).bold().dim(),
                                style("☠"),
                                &job.step.name,
                            ))
                            .expect("Could not print line");
                        let progress = map.get(&job.id).expect("Count not find ProgressBar");
                        progress.finish_and_clear();
                        multiprogress.remove(progress);
                        map.remove(&job.id);
                    }
                    Progress::ShutdownStart => {
                        let progress = multiprogress.add(ProgressBar::new_spinner());
                        progress.enable_steady_tick(Duration::from_millis(64));
                        progress.set_style(spinner_style.clone());
                        progress.set_prefix("shutdown".to_string());
                        progress.set_message("Gracefully shutting down...".to_string());
                        map.insert("shutdown".to_string(), progress.clone());
                    }
                    Progress::ShutdownFinish => {
                        multiprogress
                            .println(&format!(
                                "{} {} {}",
                                style("shutdown").bold().dim(),
                                style("✓").green(),
                                "Gracefully shut down",
                            ))
                            .expect("Could not print line");
                        let progress = map.get("shutdown").expect("Count not find ProgressBar");
                        progress.finish_and_clear();
                        multiprogress.remove(progress);
                        map.remove("shutdown");
                        break;
                    }
                }
            }

            // println!("Progress has been shutdown");
        });

        Self { tx }
    }

    pub async fn start(&self, job: PipelineJob) -> Result<()> {
        self.tx.send(Progress::Start(job)).await?;
        Ok(())
    }

    pub async fn success(&self, job: PipelineJob) -> Result<()> {
        self.tx.send(Progress::Succeed(job)).await?;
        Ok(())
    }

    pub async fn fail(&self, job: PipelineJob) -> Result<()> {
        self.tx.send(Progress::Fail(job)).await?;
        Ok(())
    }

    pub async fn terminate(&self, job: PipelineJob) -> Result<()> {
        self.tx.send(Progress::Terminate(job)).await?;
        Ok(())
    }

    pub async fn start_shutdown(&self) -> Result<()> {
        self.tx.send(Progress::ShutdownStart).await?;
        Ok(())
    }

    pub async fn finish_shutdown(&self) -> Result<()> {
        self.tx.send(Progress::ShutdownFinish).await?;
        Ok(())
    }
}
