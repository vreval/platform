<?php

namespace App\Http\Controllers;

use App\Form;
use App\Project;

class ProjectFormsController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('manage', $project);

        return response()->json(Form::where('project_id', $project->id)->select(['id', 'name', 'fields'])->get());
    }

    public function show(Project $project, Form $form)
    {
        $this->authorize('manage', $project);

        return view('forms.show', [
            'project' => $project,
            'form' => $form
        ]);
    }

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
            'fields.*.type' => ['required', 'in:header,text,section,selection,rating'],
            'fields.*.template.text' => ['string'],
            'fields.*.template.show_subtitle' => ['boolean'],
            'fields.*.template.question' => ['string'],
            'fields.*.template.subtitle' => ['string', 'nullable'],
            'fields.*.template.options' => ['array', 'between:2,7'],
            'fields.*.template.random_order' => ['boolean'],
            'fields.*.template.dropdown' => ['boolean'],
            'fields.*.template.required' => ['boolean'],
            'fields.*.template.levels' => ['numeric', 'between:2,7'],
            'fields.*.template.symbols' => ['array'],
            'fields.*.template.symbols_selection' => ['string', 'in:none,asc,mirror,pos_neg'],
            'fields.*.template.items.*.lower_bound_label' => ['string'],
            'fields.*.template.items.*.upper_bound_label' => ['string', 'nullable'],
            'fields.*.template.show_labels' => ['boolean'],
            'fields.*.template.multiple_choice' => ['boolean'],
        ]);
    }
}
