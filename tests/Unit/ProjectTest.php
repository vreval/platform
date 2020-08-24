<?php

namespace Tests\Unit;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $user = factory('App\User')->create();
        $project = factory('App\Project')->create(['owner_id' => $user->id]);

        $this->assertEquals($user->id, $project->owner->id);
    }

    /** @test */
    public function it_can_add_scenario()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create();

        $scenario = $project->addScenario('Test scenario');

        $this->assertCount(1, \App\Scenario::all());
        $this->assertTrue($project->scenarios->contains($scenario));
    }
}
