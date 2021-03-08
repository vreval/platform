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
            'tasks.*.type_id' => ['required', 'exists:task_types,id'],
            'tasks.*.settings' => ['required', 'array'],
            'tasks.*.settings.avatar' => ['array'],
            'tasks.*.settings.answer_time_limit' => ['array'],
            'tasks.*.settings.walkable_distance_limit' => ['numeric'],
            'tasks.*.settings.perimeter_boundary' => ['boolean']
        ]);

        foreach($data['tasks'] as $key => $task) {
            $task['position'] = $key;
            $scenario->tasks()->updateOrCreate(['position' => $key], $task);
        }

        // Clear tasks of higher position then found in request
        Task::where('position', '>=', count($data['tasks']))->delete();
    }
}
