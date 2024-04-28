<?php

namespace App\Listeners\Github;

use App\Events\PipelineJobFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateCommitStatus implements ShouldQueue
{
    public function handle(PipelineJobFinished $event): void
    {
        $ref = data_get($event, 'job.event.ref');
        $pipelineId = data_get($event, 'job.event.pipeline.id');
        $pipelineName = data_get($event, 'job.event.pipeline.name');
        $pipelineStepName = data_get($event, 'job.step.name');

        $response = Http::post("https://api.github.com/repos/johnnyfreeman/bilbo/statuses/{$ref}", [
            "state" => "success",
            "target_url" => route('pipelines.show', ['pipeline' => $pipelineId]),
            "description" => "The pipeline job finished!",
            "context" => "{$pipelineName} / {$pipelineStepName}",
        ]);

        Log::debug('Creating commit status', [
            'ref' => $ref,
            'pipelineId' => $pipelineId,
            'pipelineName' => $pipelineName,
            'pipelineStepName' => $pipelineStepName,
            'response' => $response,
        ]);
    }
}
