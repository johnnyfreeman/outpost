<?php

namespace App\Listeners\Github;

use App\Events\PipelineJobFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class CreateCommitStatus implements ShouldQueue
{
    public function handle(PipelineJobFinished $event): void
    {
        if ($ref = data_get($event, 'job.event.ref')) {
            $pipelineId = data_get($event, 'job.event.pipeline.id');
            $pipelineName = data_get($event, 'job.event.pipeline.name');
            $pipelineStepName = data_get($event, 'job.step.name');
            Http::post("https://api.github.com/repos/johnnyfreeman/bilbo/statuses/{$ref}", [
                "state" => "success",
                "target_url" => route('pipeline.show', ['pipeline' => $pipelineId]),
                "description" => "The pipeline job finished!",
                "context" => "{$pipelineName} / {$pipelineStepName}",
            ]);
        }
    }
}
