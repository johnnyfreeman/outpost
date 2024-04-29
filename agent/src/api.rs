use chrono::{DateTime, Utc};
use dialoguer::{theme::ColorfulTheme, Input};
use reqwest::header;
use serde::{Deserialize, Serialize};
use serde_json::json;
use std::env;
use tokio::sync::oneshot;

pub struct Api {
    id: String,
    url: String,
    client: reqwest::Client,
    token: String,
}

impl Api {
    pub fn new() -> anyhow::Result<Self> {
        let mut headers = header::HeaderMap::new();
        headers.insert(
            header::ACCEPT,
            header::HeaderValue::from_static("application/json"),
        );

        Ok(Self {
            id: env::var("ID").unwrap_or_else(|_| {
                Input::with_theme(&ColorfulTheme::default())
                    .with_prompt("Agent ID")
                    .interact_text()
                    .unwrap()
            }),
            url: env::var("API_URL").unwrap_or_else(|_| {
                Input::with_theme(&ColorfulTheme::default())
                    .with_prompt("API Url")
                    .default("http://localhost/api".to_string())
                    .interact_text()
                    .unwrap()
            }),
            client: reqwest::Client::builder()
                .default_headers(headers)
                .build()?,
            token: "".to_string(),
        })
    }

    pub async fn get_next_job(&self) -> anyhow::Result<reqwest::Response> {
        Ok(self
            .client
            .post(format!("{}/pipeline-jobs/reserve", self.url))
            .bearer_auth(self.token.clone())
            .send()
            .await?)
    }

    pub async fn update_job(&self, job: PipelineJob) -> anyhow::Result<reqwest::Response> {
        Ok(self
            .client
            .post(format!("{}/pipeline-jobs/{}", self.url, job.id))
            .bearer_auth(self.token.clone())
            .json(&job)
            .header(header::ACCEPT, "application/json")
            .send()
            .await?)
    }

    pub async fn refresh_token(&mut self) -> anyhow::Result<()> {
        let response = self
            .client
            .post(format!("{}/agents/token", self.url,))
            .json(&json!({
                "agent_id":self.id,
                "token_name":"bearer",
            }))
            .send()
            .await?;

        let token_response: TokenResponse = response.json().await?;

        self.token = token_response.token;

        Ok(())
    }
}

pub enum ApiAction {
    GetNextPipelineJob {
        tx: oneshot::Sender<Option<PipelineJob>>,
    },
    UpdatePipelineJob(PipelineJob),
}

#[derive(Clone, Debug, Deserialize, Serialize)]
pub struct PipelineJobResponse {
    pub data: Option<PipelineJob>,
}

#[derive(Clone, Debug, Deserialize, Serialize)]
pub struct TokenResponse {
    pub token: String,
}

#[derive(Clone, Debug, Deserialize, Serialize)]
pub struct PipelineJob {
    pub id: String,
    pub step: PipelineStep,
    pub event: PipelineEvent,
    pub output: Option<String>,
    pub exit_code: Option<i32>,
    pub created_at: DateTime<Utc>,
    pub updated_at: DateTime<Utc>,
    pub reserved_at: Option<DateTime<Utc>>,
    pub started_at: Option<DateTime<Utc>>,
    pub finished_at: Option<DateTime<Utc>>,
}

impl PipelineJob {
    pub fn append_output(&mut self, output: &str) {
        self.output = match &self.output {
            Some(old_output) => Some(old_output.to_owned() + "\n" + output),
            None => Some(output.to_string()),
        };
    }
}

#[derive(Clone, Debug, Deserialize, Serialize)]
pub struct PipelineStep {
    pub id: String,
    pub pipeline_id: String,
    pub name: String,
    pub env: Option<String>,
    pub current_directory: Option<String>,
    pub script: String,
    pub created_at: DateTime<Utc>,
    pub updated_at: DateTime<Utc>,
}

#[derive(Clone, Debug, Deserialize, Serialize)]
pub struct PipelineEvent {
    pub id: String,
    pub pipeline: Pipeline,
    pub description: Option<String>,
    pub created_at: DateTime<Utc>,
    pub updated_at: DateTime<Utc>,
}

#[derive(Clone, Debug, Deserialize, Serialize)]
pub struct Pipeline {
    pub id: String,
    pub name: String,
    pub description: Option<String>,
    pub created_at: DateTime<Utc>,
    pub updated_at: DateTime<Utc>,
}
