<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectPinsController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('manage', $project);

        $project->pinBy(auth()->user());

        if (request()->wantsJson()) {
            return ['message' => $project->name . ' pinned.'];
        }

        return redirect()->back()->with('message', $project->name . ' pinned.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->unpinBy(auth()->user());

        if (request()->wantsJson()) {
            return ['message' => $project->name . ' unpinned.'];
        }

        return redirect()->back()->with('message', $project->name . ' unpinned.');
    }
}
