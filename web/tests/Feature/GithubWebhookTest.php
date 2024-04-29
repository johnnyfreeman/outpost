<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pipeline;
use App\Models\PipelineStep;
use App\Models\GithubSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function testWebhookWithoutSignature(): void
    {
        [$headers, $body] = json_decode(file_get_contents('./tests/fixtures/valid_github_push_webhook.json'), true);
        unset($headers['X-Hub-Signature-256']);

        $response = $this->post(route('webhook-client-github'), $body, $headers);

        $response->assertInternalServerError();
    }

    public function testPushRunsPipeline(): void
    {
        Pipeline::factory()
            ->has(PipelineStep::factory()->count(2), 'steps')
            ->has(GithubSetting::factory()->state([
                'trigger_on_push' => true,
            ]), 'githubSettings')
            ->create();
        [$headers, $body] = json_decode(file_get_contents('./tests/fixtures/valid_github_push_webhook.json'), true);

        $response = $this->post(route('webhook-client-github'), $body, $headers);

        $response->assertOk();
        $this->assertDatabaseCount('pipeline_jobs', 2);
    }
}
