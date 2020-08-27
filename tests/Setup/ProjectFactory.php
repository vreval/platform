<?php

namespace Tests\Setup;

use App\Project;
use App\Scenario;
use App\User;

class ProjectFactory
{
    private $scenariosCount = 0;
    private $user;

    public function withScenarios($count)
    {
        $this->scenariosCount = $count;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?? factory(User::class)
        ]);

        factory(Scenario::class, $this->scenariosCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}
