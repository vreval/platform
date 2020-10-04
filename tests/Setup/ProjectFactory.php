<?php

namespace Tests\Setup;

use App\Checkpoint;
use App\Project;
use App\Scenario;
use App\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ProjectFactory
{
    private $scenariosCount = 0;
    private $user;
    private $checkpointsCount = 0;

    public function withScenarios($count)
    {
        $this->scenariosCount = $count;

        return $this;
    }

    public function withCheckpoints($count)
    {
        $this->checkpointsCount = $count;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $project = Project::factory()->create([
            'owner_id' => $this->user ?? User::factory()
        ]);

        Scenario::factory()
            ->count($this->scenariosCount)
            ->create(['project_id' => $project->id]);

        return $project;
    }
}
