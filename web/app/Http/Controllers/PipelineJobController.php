<?php

namespace App\Http\Controllers;

use App\Models\PipelineJob;
use Illuminate\Http\Request;
use App\Events\PipelineJobStarted;
use Illuminate\Support\Facades\DB;
use App\Events\PipelineJobFinished;
use App\Events\PipelineJobReserved;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\PipelineJobResource;
use Illuminate\Contracts\Events\Dispatcher;

class PipelineJobController extends Controller
{
    public function reserve(Request $request)
    {
        return DB::transaction(function () use ($request) {
            if ($job = PipelineJob::lockForUpdate()
                // ->where('queue', $this->getQueue($queue))
                ->isAvailable()
                ->orWhere(function (Builder $query) {
                    $query->isNotFinished()->isReservedButExpired();
                })
                ->orderBy('id', 'asc')
                ->first()) {

                $job->update([
                    'reserved_at' => now(),
                    'agent_id' => $request->user()->getKey(),
                ]);

                event(new PipelineJobReserved($job));

                return new PipelineJobResource($job->load(['event.pipeline', 'step']));
            }

            return ['data' => null];
        });
    }

    public function update(Request $request, PipelineJob $job, Dispatcher $dispatcher): PipelineJobResource
    {
        $validated = $this->validate($request, [
            'output' => ['nullable'],
            'exit_code' => ['nullable'],
            'reserved_at' => ['nullable'],
            'started_at' => ['nullable'],
            'finished_at' => ['nullable'],
        ]);

        $job->fill($validated)->save();

        if ($job->wasChanged('started_at')) {
            $dispatcher->dispatch(new PipelineJobStarted($job));
        }

        if ($job->wasChanged('finished_at')) {
            $dispatcher->dispatch(new PipelineJobFinished($job));
        }

        return new PipelineJobResource($job);
    }
}
