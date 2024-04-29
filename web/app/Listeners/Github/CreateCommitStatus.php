<?php

namespace App\Listeners\Github;

use App\Events\PipelineJobFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Integrations\Github\CommitStatus;
use App\Http\Integrations\Github\GithubConnector;
use App\Http\Integrations\Github\Requests\CreateCommitStatusRequest;

class CreateCommitStatus implements ShouldQueue
{
    public function handle(PipelineJobFinished $event, GithubConnector $github): void
    {
        $ref = data_get($event, 'job.event.ref');
        $pipelineId = data_get($event, 'job.event.pipeline.id');
        $pipelineName = data_get($event, 'job.event.pipeline.name');
        $pipelineStepName = data_get($event, 'job.step.name');

        $github->send(new CreateCommitStatusRequest(
            owner: 'johnnyfreeman',
            repo: 'bilbo',
            ref: $ref,
            commitStatus: new CommitStatus(
                state: "success",
                target_url: route('pipelines.show', ['pipeline' => $pipelineId]),
                description: "The pipeline job finished!",
                context: "{$pipelineName} / {$pipelineStepName}",
            ),
        ));
    }
}
