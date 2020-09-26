<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('projects.index', ['projects' => auth()->user()->availableProjects()]);
    }

    public function show(Project $project)
    {
        $this->authorize('manage', $project);

        return view('projects.show', ['project' => $project]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    public function update(Project $project)
    {
        $this->authorize('manage', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        if ($members = request('members')) {
            foreach($members as $member) {
                $userToInvite = User::whereEmail($member['email'])->first();
                $project->invite($userToInvite);
            }
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('administer', $project);

        $project->delete();

        return redirect('/projects');
    }

    /**
     * @return array
     */
    protected function validateRequest(): array
    {
        return request()->validate([
            'name' => ['required', 'min:3', 'max:150'],
            'description' => ['required', 'min:3', 'max:500'],
        ]);
    }
}
