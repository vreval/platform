<?php

namespace App\Http\Controllers;

use App\Project;
use App\Scenario;
use Illuminate\Http\Request;

class ProjectScenariosController extends Controller
{
    public function store(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        request()->validate([
            'name' => ['required', 'min:3', 'max:150']
        ]);

        $project->addScenario(request('name'));

        return redirect($project->path());
    }

    public function update(Project $project, Scenario $scenario)
    {
        if (auth()->user()->isNot($scenario->project->owner)) {
            abort(403);
        }

        $scenario->update([
            'name' => request('name')
        ]);

        return redirect($project->path());
    }

    public function destroy(Project $project, Scenario $scenario)
    {
        if (auth()->user()->isNot($scenario->project->owner)) {
            abort(403);
        }

        $scenario->delete();

        return redirect($project->path());
    }
}
