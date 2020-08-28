<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectScenarioTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_scenarios()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/scenarios', ['name' => 'Test scenario']);

        $this->get($project->path())->assertSee('Test scenario');
    }

    /** @test */
    public function only_the_owner_of_a_project_can_add_scenarios()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->post($project->path() . '/scenarios', ['name' => 'Test scenario'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('scenarios', ['name' => 'Test scenario']);
    }

    /** @test */
    public function only_the_owner_of_a_project_can_update_a_scenario()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)->withScenarios(1)->create();

        $this->patch($project->scenarios->first()->path(), ['name' => 'Updated'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('scenarios', ['name' => 'Updated']);
    }

    /** @test */
    public function a_scenario_requires_a_name()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $scenario = factory('App\Scenario')->raw(['name' => '']);

        $this->post($project->path() . '/scenarios', $scenario)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_scenario_can_be_updated()
    {
        $project = app(ProjectFactory::class)->withScenarios(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->scenarios->first()->path(), ['name' => 'Updated scenario name'])
            ->assertSessionHasNoErrors();

        $this->assertEquals('Updated scenario name', $project->scenarios()->first()->name);

        $this->assertDatabaseHas('scenarios', [
            'name' => 'Updated scenario name'
        ]);
    }

    /** @test */
    public function a_user_can_delete_their_scenarios()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->withScenarios(1)
            ->create();
        $scenario = $project->scenarios->first();

        $this->assertDatabaseCount('scenarios', 1);

        $this->delete($scenario->path())
            ->assertRedirect($project->path());

        $this->assertDatabaseCount('scenarios', 0);
    }
}