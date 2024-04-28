<?php

namespace App\Listeners\Github;

use App\Events\PipelineJobFinished;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class CreateCommitStatus implements ShouldQueue
{
    public function handle(PipelineJobFinished $event): void
    {
        $ref = data_get($event, 'job.event.ref');
        $pipelineId = data_get($event, 'job.event.pipeline.id');
        $pipelineName = data_get($event, 'job.event.pipeline.name');
        $pipelineStepName = data_get($event, 'job.step.name');

        $response = Http::withToken($this->getAccessToken())
            ->post("https://api.github.com/repos/johnnyfreeman/bilbo/statuses/{$ref}", [
                "state" => "success",
                "target_url" => route('pipelines.show', ['pipeline' => $pipelineId]),
                "description" => "The pipeline job finished!",
                "context" => "{$pipelineName} / {$pipelineStepName}",
            ]);

        Log::debug('Creating commit status', [
            'access_token' => $this->getAccessToken(),
            'ref' => $ref,
            'pipelineId' => $pipelineId,
            'pipelineName' => $pipelineName,
            'pipelineStepName' => $pipelineStepName,
            'response' => $response,
        ]);
    }

    protected function getJWT(): string
    {
        return JWT::encode([
            'iss' => config('services.github.id'),
            'iat' => now(),
            'exp' => now()->addMinutes(5),
        ], config('services.github.private_key'), 'RS256');
    }

    protected function getAccessToken(): string
    {
        if ($token = Cache::get('github:access_token')) {
            return $token;
        }

        $response = Http::withToken($this->getJWT())
            ->post("https://api.github.com/app/installations/44973831/access_tokens");

        Cache::put(
            'github:access_token',
            $token = $response->json('token'),
            $response->json('expires_at'),
        );

        return $token;
    }
}
