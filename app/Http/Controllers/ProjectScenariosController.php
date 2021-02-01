<?php

namespace App\Http\Controllers;

use App\Project;
use App\Scenario;

class ProjectScenariosController extends Controller
{
    public function show(Project $project, Scenario $scenario)
    {
        $this->authorize('manage', $project);

        return view('scenarios.show', [
            'project' => $project,
            'scenario' => $scenario
        ]);
    }

    public function store(Project $project)
    {
        $this->authorize('manage', $project);

        $project->scenarios()->create(request()->validate([
            'name' => ['required', 'min:3', 'max:150'],
            'description' => ['min:3', 'max:500'],
        ]));

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function update(Project $project, Scenario $scenario)
    {
        $this->authorize('manage', $scenario->project);

        $scenario->update($this->validatedData());

        foreach($this->validatedData()['tasks'] as $key => $task) {
            $task['position'] = $key + 1;
            $scenario->tasks()->create($task);
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($scenario->project->path());
    }

    public function destroy(Project $project, Scenario $scenario)
    {
        $this->authorize('manage', $scenario->project);

        $scenario->delete();

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => ['required', 'min:3', 'max:150'],
            'description' => ['min:3', 'max:500'],
            'tasks' => ['required', 'array'],
            'tasks.*.start_checkpoint_id' => ['exists:checkpoints,id'],
            'tasks.*.start_form_id' => ['exists:forms,id'],
            'tasks.*.type_id' => ['required', 'exists:task_types,id'],
            'tasks.*.settings' => ['required', 'array']
        ]);
    }
}
