<?php

namespace App\Http\Controllers;

use App\Http\Resources\PipelineJobResource;
use App\Models\PipelineJob;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PipelineJobController extends Controller
{
    public function next(Request $request)
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

                return new PipelineJobResource($job->load(['event.pipeline', 'step']));
            }

            return ['data' => null];
        });
    }

    public function update(Request $request, PipelineJob $job): PipelineJobResource
    {
        $validated = $this->validate($request, [
            'output' => ['nullable'],
            'exit_code' => ['nullable'],
            'reserved_at' => ['nullable'],
            'started_at' => ['nullable'],
            'finished_at' => ['nullable'],
        ]);

        $job->fill($validated)->save();

        return new PipelineJobResource($job);
    }
}
