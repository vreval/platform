<?php

namespace App\Http\Controllers;

use App\Form;
use App\Project;

class ProjectFormTaskController extends Controller
{
    public function update(Project $project, Form $form)
    {
        $this->authorize('manage', $project);

        $validatedData = request()->validate([
            'type' => ['required', 'in:App\Annotation,App\Pointing'],
            'description' => ['required', 'between:3,255']
        ]);
        $validatedData['project_id'] = $project->id;

        if ($existingTask = $form->task) {
            if ($existingTask->type === $validatedData['type']) {
                $existingTask->update($validatedData);
            } else {
                $existingTask->delete();

                app($validatedData['type'])
                    ->saveWith($validatedData)
                    ->assignTo($form);
            }
        } else {
            app($validatedData['type'])
                ->saveWith($validatedData)
                ->assignTo($form);
        }

        if (request()->wantsJson()) {
            return response()->json($form->fresh());
        }

        return redirect($project->path());
    }
}
