<?php

namespace App\Http\Controllers;

use App\Form;
use App\Project;
use Illuminate\Http\Request;

class ProjectFormsController extends Controller
{
    public function store(Project $project)
    {
        $project->forms()->create(request()->validate([
            'name' => ['required', 'min:3', 'max:150'],
        ]));
    }
}
