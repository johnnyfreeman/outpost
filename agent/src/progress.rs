use std::collections::BTreeMap;

use crate::api::PipelineJob;
use indicatif::{MultiProgress, ProgressBar, ProgressStyle};
use tokio::spawn;
use tokio::sync::mpsc;
use tokio::sync::mpsc::Sender;

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

        let spinner_style = ProgressStyle::with_template("{prefix:.bold.dim} {spinner} {wide_msg}")
            .unwrap()
            .tick_chars("⠁⠂⠄⡀⢀⠠⠐⠈ ");

        let mut map: BTreeMap<String, ProgressBar> = BTreeMap::new();

        loop {
            for (_, progress) in map.iter() {
                progress.tick();
            }

            if let Some(action) = rx.recv().await {
                match action {
                    Progress::Start(job) => {
                        let progress = multiprogress.add(ProgressBar::new_spinner());
                        progress.set_style(spinner_style.clone());
                        progress.set_prefix(job.id.clone());
                        progress.set_message(job.step.name.clone());
                        progress.tick();
                        map.insert(job.id, progress.clone());
                    }
                    Progress::Succeed(job) => {
                        let progress = map.get(&job.id).expect("Count not find ProgressBar");

                        progress.finish_with_message(format!("{} {}", "✓", job.step.name.clone()));
                        // multiprogress.remove(progress);
                        map.remove(&job.id);
                    }
                    Progress::Fail(job) => {
                        let progress = map.get(&job.id).expect("Count not find ProgressBar");
                        progress.finish_with_message(format!("{} {}", "✗", job.step.name.clone()));
                    }
                    Progress::Terminate(job) => {
                        let progress = map.get(&job.id).expect("Count not find ProgressBar");
                        progress.finish_with_message("terminated");
                    }
                }
            }
        }
    });

    tx
}
