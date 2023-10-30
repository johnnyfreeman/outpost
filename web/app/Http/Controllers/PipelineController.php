<?php

namespace App\Http\Controllers;

use App\Models\Pipeline;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function index(Request $request)
    {
        return view('pipelines.index', [
            'pipelines' => Pipeline::orderBy('id')->paginate(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => [ 'required' ],
            'description' => [ 'nullable' ],
        ]);

        $pipeline = Pipeline::create($data);

        return to_route('pipelines.show', $pipeline)
            ->with('success', [
                'pipeline created!',
                'subsequent events will now trigger executions of this pipeline.',
            ]);
    }

    public function update(Request $request, Pipeline $pipeline)
    {
        $data = $this->validate($request, [
            'name' => [ 'required' ],
            'description' => [ 'nullable' ],
        ]);

        $pipeline->fill($data)->save();

        return to_route('pipelines.show', $pipeline)
            ->with('success', [
                'pipeline updated!',
                'subsequent executions of this pipeline will utilize your new changes.',
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
        ]);
    }
}
