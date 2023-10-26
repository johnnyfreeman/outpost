use tokio::time::{Duration, sleep};
use reqwest;
use std::env;
use tokio::spawn;
use std::process::Stdio;
use tokio::sync::mpsc;
use tokio::io::{BufReader, AsyncBufReadExt};
use serde::Deserialize;
use anyhow::Result;

#[derive(Debug, Deserialize)]
struct Task {
    id: String,
    command: String,
}

#[tokio::main]
async fn main() {
    // TODO: Initialize tracing

    let (tx, rx) = mpsc::channel(32);

    spawn(async move {
        send_output_to_server(rx).await;
    });

    loop {
        // Send an HTTP request to reserve and take a task
        let name = hostname::get().unwrap();
        let tx = tx.clone();

        // TODO: this url should be configurable (env? confy?)
        let request_url = format!("https://6537e89aa543859d1bb104a2.mockapi.io/api/v1/tasks/next?name={:?}", name);

        let response = reqwest::get(&request_url).await.unwrap();

        if response.status().is_success() {
            let task: Task = response.json().await.expect("Failed to deserialize task response");

            spawn(async move {
                process_task(task, tx).await;
            });
        }

        let sleep_duration = Duration::from_secs(
            env::var("SLEEP_DURATION")
                .unwrap_or("5".to_string())
                .parse()
                .expect("Invalid sleep duration"),
        );

        sleep(sleep_duration).await;
    }
}

async fn process_task(task: Task, tx: mpsc::Sender<String>) {
    let child = tokio::process::Command::new("sh")
        .arg("-c")
        .arg(&task.command)
        .stdout(Stdio::piped())
        .spawn()
        .expect("Failed to execute command");

    if let Some(stdout) = child.stdout {
        let mut lines = BufReader::new(stdout).lines();
        while let Some(line) = lines.next_line().await.unwrap() {
            // println!("length = {}", line.len())
            if tx.send(line).await.is_err() {
                eprintln!("Failed to send output line");
                break;
            }
        }
    }
}

async fn send_output_to_server(mut lines: mpsc::Receiver<String>) {
    while let Some(line) = lines.recv().await {
        let _response = format!("{}\n", line);
        // TODO: update task output on client
    }
}
