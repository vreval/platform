<?php

namespace App\Http\Controllers;

use App\Project;
use App\Scenario;

class ProjectScenariosController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('manage', $project);

        $project->addScenario(request()->validate([
            'name' => ['required', 'min:3', 'max:150'],
            'description' => ['min:3', 'max:500'],
            'checkpoints' => ['array'],
            'checkpoints.*.id' => ['required', 'numeric'],
            'checkpoints.*.project_id' => ['required', 'numeric'],
        ]));

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function update(Project $project, Scenario $scenario)
    {
        $this->authorize('manage', $scenario->project);

        $scenario->update([
            'name' => request('name')
        ]);

        return redirect($scenario->project->path());
    }

    public function destroy(Project $project, Scenario $scenario)
    {
        $this->authorize('manage', $scenario->project);

        $scenario->delete();

        return redirect($project->path());
    }
}
