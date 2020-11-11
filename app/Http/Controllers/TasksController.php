<?php

namespace App\Http\Controllers;

use App\Project;
use App\Scenario;
use App\Task;

class TasksController extends Controller
{
    public function store(Project $project, Scenario $scenario)
    {
        $this->authorize('manage', $project);

        $data = request()->validate([
            'tasks' => ['required', 'array'],
            'tasks.*.start_checkpoint_id' => ['exists:checkpoints,id'],
            'tasks.*.start_form_id' => ['exists:forms,id'],
//            'tasks.*.type_id' => ['required', 'exists:task_types,id'],
            'tasks.*.settings' => ['required', 'array']
        ]);

        // Clear tasks before storing new ones
        Task::where('scenario_id', $scenario->id)->delete();

        foreach($data['tasks'] as $key => $task) {
            $task['position'] = $key;
            $scenario->tasks()->create($task);
        }
    }
}
