<?php

namespace App\Http\Controllers;

use App\Form;
use App\Project;
use Illuminate\Http\Request;

class ProjectFormsController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('manage', $project);

        $project->forms()->create($this->validatedData());

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function update(Project $project, Form $form)
    {
        $this->authorize('manage', $project);

        $form->update($this->validatedData());

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    /**
     * @return array
     */
    protected function validatedData(): array
    {
        return request()->validate([
            'name' => ['required', 'min:3', 'max:150'],
            'description' => ['min:3', 'max:500'],
            'fields' => ['array'],
            'fields.*.type' => ['required', 'in:header,text,new_section,selection,evaluation']
        ]);
    }
}
