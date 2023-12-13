<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        return AgentResource::collection(
            Agent::paginate()
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => ['required'],
        ]);

        $agent = Agent::create($validated);

        return new AgentResource($agent);
    }

    public function createToken(Request $request)
    {
        $validated = $this->validate($request, [
            'agent_id' => ['required'],
            'token_name' => ['required'],
        ]);

        return [
            'token' => Agent::findOrFail($validated['agent_id'])
                ->createToken($validated['token_name'], ['reserve-job', 'update-job'])
                ->plainTextToken,
        ];
    }
}
