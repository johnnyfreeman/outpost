<?php

namespace App\Http\Controllers;

use App\Models\Pipeline;
use App\Models\PipelineStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PipelineController extends Controller
{
    public function index(Request $request)
    {
        return view('pipelines.index', [
            'pipelines' => Pipeline::query()
                ->with(['latestEvent.jobs'])
                ->orderBy('id')
                ->paginate(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $pipeline = DB::transaction(function () use ($request, $data) {
            $pipeline = Pipeline::create($data);

            $pipeline->steps()->createMany([
                // ...
            ]);

            $pipeline->githubSettings()->create([
                'trigger_on_push' => $request->boolean('trigger_on_push'),
            ]);

            return $pipeline;
        });

        return to_route('pipelines.show', $pipeline)
            ->with('success', [
                'pipeline created!',
                'subsequent events will now trigger executions of this pipeline.',
            ]);
    }

    public function update(Request $request, Pipeline $pipeline)
    {
        $data = $this->validate($request, [
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $pipeline->fill($data)->save();

        $pipeline->githubSettings()->updateOrCreate([], [
            'trigger_on_push' => $request->boolean('trigger_on_push'),
        ]);

        return to_route('pipelines.show', $pipeline)
            ->with('success', [
                'pipeline updated!',
                'subsequent executions of this pipeline will utilize your new changes.',
            ]);
    }

    public function run(Request $request, Pipeline $pipeline)
    {
        $pipeline->run();

        return to_route('pipelines.show', $pipeline)
            ->with('success', [
                'pipeline jobs queued!',
                'these jobs will be processed as soon as an agent becomes available.',
            ]);
    }

    public function runStep(Request $request, Pipeline $pipeline, PipelineStep $step)
    {
        $event = $pipeline->events()->create();

        $step->jobs()->create([
            'pipeline_event_id' => $event->getKey(),
        ]);

        return to_route('pipelines.show', $pipeline)
            ->with('success', [
                'pipeline jobs queued!',
                'these jobs will be processed as soon as an agent becomes available.',
            ]);
    }

    public function create(Request $request)
    {
        return view('pipelines.create');
    }

    public function edit(Request $request, Pipeline $pipeline)
    {
        return view('pipelines.edit', [
            'pipeline' => $pipeline,
        ]);
    }

    public function show(Request $request, Pipeline $pipeline)
    {
        return view('pipelines.show', [
            'pipeline' => $pipeline,
            'events' => $pipeline->events()->with([
                'jobs' => function (HasMany $query) {
                    $query->orderBy('id', 'desc');
                },
                'jobs.step',
                'jobs.agent',
            ])->orderByDesc('id')->paginate(),
        ]);
    }
}
