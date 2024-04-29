<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        return view('agents.index', [
            'agents' => Agent::query()
                ->with(['lastUsedToken'])
                ->orderBy('id')
                ->paginate(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required'],
        ]);

        $agent = Agent::create($data);

        return to_route('agents.show', $agent)
            ->with('success', [
                'agent registered!',
                'you may now run an agent using this id.',
            ]);
    }

    public function update(Request $request, Agent $agent)
    {
        $data = $this->validate($request, [
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $agent->fill($data)->save();

        return to_route('agents.show', $agent)
            ->with('success', [
                'agent updated!',
                'subsequent executions of this agent will utilize your new changes.',
            ]);
    }

    public function run(Request $request, Agent $agent)
    {
        $event = $agent->events()->create();

        $agent->steps->map(fn ($step) => $step->jobs()->create([
            'agent_event_id' => $event->getKey(),
        ]));

        return to_route('agents.show', $agent)
            ->with('success', [
                'agent jobs queued!',
                'these jobs will be processed as soon as an agent becomes available.',
            ]);
    }

    public function runStep(Request $request, Agent $agent, AgentStep $step)
    {
        $event = $agent->events()->create();

        $step->jobs()->create([
            'agent_event_id' => $event->getKey(),
        ]);

        return to_route('agents.show', $agent)
            ->with('success', [
                'agent jobs queued!',
                'these jobs will be processed as soon as an agent becomes available.',
            ]);
    }

    public function create(Request $request)
    {
        return view('agents.create');
    }

    public function edit(Request $request, Agent $agent)
    {
        return view('agents.edit', [
            'agent' => $agent,
        ]);
    }

    public function show(Request $request, Agent $agent)
    {
        return view('agents.show', [
            'agent' => $agent,
            'pings' => collect(),
            // 'pings' => $agent->pings()->with([
            //     'jobs' => function (HasMany $query) {
            //         $query->orderBy('id', 'desc');
            //     },
            //     'jobs.step',
            // ])->orderByDesc('id')->paginate(),
        ]);
    }
}
