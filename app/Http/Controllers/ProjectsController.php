<?php

namespace App\Http\Controllers;

use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('projects.index', ['projects' => auth()->user()->projects]);
    }

    public function show(Project $project)
    {
        $this->authorize('manage', $project);

        return view('projects.show', ['project' => $project]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    public function update(Project $project)
    {
        $this->authorize('manage', $project);

        $validatedAttributes = request()->validate([
            'name' => ['min:3', 'max:150'],
            'description' => ['min:3', 'max:500'],
        ]);

        $project->update($validatedAttributes);

        return redirect($project->path());
    }

    public function store()
    {
        $validatedAttributes = request()->validate([
            'name' => ['required', 'min:3', 'max:150'],
            'description' => ['required', 'min:3', 'max:500'],
        ]);

        $project = auth()->user()->projects()->create($validatedAttributes);

        return redirect($project->path());
    }
}
