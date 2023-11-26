use std::collections::BTreeMap;

use crate::api::PipelineJob;
use console::style;
use indicatif::{MultiProgress, ProgressBar, ProgressStyle};
use tokio::spawn;
use tokio::sync::mpsc;
use tokio::sync::mpsc::Sender;
use tokio::time::Duration;

pub enum Progress {
    Start(PipelineJob),
    Succeed(PipelineJob),
    Fail(PipelineJob),
    Terminate(PipelineJob),
}

pub fn initialize_progress_bars() -> Sender<Progress> {
    let (tx, mut rx) = mpsc::channel(32);

    spawn(async move {
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
            }
        }
    });

    tx
}
