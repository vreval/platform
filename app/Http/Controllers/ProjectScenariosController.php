<?php

namespace App\Http\Controllers;

use App\Project;
use App\Scenario;

class ProjectScenariosController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('manage', $project);

        request()->validate([
            'name' => ['required', 'min:3', 'max:150']
        ]);

        $project->addScenario(request('name'));

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
