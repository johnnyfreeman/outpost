<?php

namespace App\Jobs;

use App\Models\GithubSetting;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\HeaderBag;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessGithubWebhookJob extends ProcessWebhookJob
{
    public function handle()
    {
        $headers = new HeaderBag($this->webhookCall->headers);
        $payload = new Collection($this->webhookCall->payload);

        if ($headers->contains('x-github-event', 'push')) {
            GithubSetting::with('pipeline.steps')->where('trigger_on_push', true)->chunkById(500, function ($settings) use ($payload) {
                /** @var \App\Models\GithubSetting */
                foreach ($settings as $setting) {
                    /** @var \App\Models\Pipeline */
                    $pipeline = $setting->pipeline;

                    /** @var \App\Models\PipelineEvent */
                    $event = $pipeline->events()->create([
                        'description' => $payload->dot()->get('head_commit.message'),
                        'url' => $payload->dot()->get('head_commit.url'),
                        'ref' => $payload->dot()->get('head_commit.id'),
                    ]);

                    $pipeline->steps->map(fn ($step) => $step->jobs()->create([
                        'pipeline_event_id' => $event->getKey(),
                    ]));
                }
            });
        }
    }
}
