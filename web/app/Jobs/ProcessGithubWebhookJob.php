<?php

namespace App\Jobs;

use App\Models\GithubSetting;
use Illuminate\Support\Collection;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Symfony\Component\HttpFoundation\HeaderBag;

class ProcessGithubWebhookJob extends ProcessWebhookJob
{
    public function handle()
    {
        $headers = new HeaderBag($this->webhookCall->headers);
        $payload = new Collection($this->webhookCall->payload);

        if ($headers->contains('x-github-event', 'push')) {
            GithubSetting::with('pipeline.steps')->where('trigger_on_push', true)->chunkById(500, function ($settings) use ($payload) {
                foreach ($settings as $setting) {
                    $setting->pipeline->run($payload->get('head_commit.url'));
                }
            });
        }
    }
}
