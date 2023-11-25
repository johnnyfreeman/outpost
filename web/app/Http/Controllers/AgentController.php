<?php

namespace App\Http\Controllers;

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

    public function createToken(Agent $agent)
    {
        return [
            'token' => $agent->createToken('primary', ['reserve-job', 'update-job'])->plainTextToken,
        ];
    }
}
