<?php

namespace App\Http\Controllers;

use App\Project;
use App\Scenario;
use Illuminate\Http\Request;

class ProjectScenariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Project $project)
    {
        request()->validate([
            'name' => ['required', 'min:3', 'max:150']
        ]);

        $project->addScenario(request('name'));

        return redirect($project->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Scenario  $scenario
     * @return \Illuminate\Http\Response
     */
    public function show(Scenario $scenario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Scenario  $scenario
     * @return \Illuminate\Http\Response
     */
    public function edit(Scenario $scenario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scenario  $scenario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scenario $scenario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scenario  $scenario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scenario $scenario)
    {
        //
    }
}
