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
            'fields' => ['required', 'array'],
            'fields.*.start_checkpoint_id' => ['exists:checkpoints,id'],
            'fields.*.start_form_id' => ['exists:forms,id'],
            'fields.*.type_id' => ['required', 'exists:task_types,id'],
            'fields.*.settings' => ['required', 'array']
        ]);

        // Clear tasks before storing new ones
        Task::where('scenario_id', $scenario->id)->delete();

        foreach($data['fields'] as $key => $task) {
            $task['position'] = $key;
            $scenario->fields()->create($task);
        }
    }
}
