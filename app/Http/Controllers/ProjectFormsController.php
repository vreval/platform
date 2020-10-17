<?php

namespace App\Http\Controllers;

use App\Form;
use App\Project;

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
            'fields.*.type' => ['required', 'in:header,text,section,selection,evaluation'],
            'fields.*.template.text' => ['string'],
            'fields.*.template.show_subtitle' => ['boolean'],
            'fields.*.template.question' => ['string'],
            'fields.*.template.subtitle' => ['string'],
            'fields.*.template.options' => ['array', 'between:2,7'],
            'fields.*.template.random_order' => ['boolean'],
            'fields.*.template.dropdown' => ['boolean'],
            'fields.*.template.required' => ['boolean'],
            'fields.*.template.scale_size' => ['numeric', 'between:2,7'],
            'fields.*.template.lower_bound_label' => ['string'],
            'fields.*.template.upper_bound_label' => ['string'],
            'fields.*.template.show_labels' => ['boolean'],
            'fields.*.template.multiple_choice' => ['boolean'],
        ]);
    }
}
