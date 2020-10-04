<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectCheckpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_checkpoints()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/checkpoints', ['name' => 'Test scenario']);

        $this->get($project->path())->assertSee('Test scenario');
    }
}
