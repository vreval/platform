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
            'description' => ['min:3', 'max:500']
        ]));

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
