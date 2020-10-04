<?php

namespace Tests\Unit;

use App\Project;
use App\Scenario;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        $this->assertEquals($user->id, $project->owner->id);
    }

    /** @test */
    public function it_can_add_scenario()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $scenario = $project->addScenario(['name' => 'Test scenario']);

        $this->assertCount(1, Scenario::all());
        $this->assertTrue($project->scenarios->contains($scenario));
    }

    /** @test */
    public function it_can_invite_a_user()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $project->invite($user = User::factory()->create());

        $this->assertTrue($project->members->contains($user));
    }
}
