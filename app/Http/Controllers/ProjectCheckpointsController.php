<?php

namespace App\Http\Controllers;

use App\Checkpoint;
use App\Project;
use Illuminate\Http\Request;

class ProjectCheckpointsController extends Controller
{
    public function store(Project $project)
    {
       $project->addCheckpoint(request()->validate([
           'name' => ['required', 'min:3', 'max:150'],
           'position' => ['array', 'min:3', 'max:3'],
           'position.*' => ['numeric'],
           'rotation.*' => ['numeric'],
       ]));

       return redirect($project->path());
    }

    public function index(Project $project)
    {
        return ['checkpoints' => $project->checkpoints];
    }
}
