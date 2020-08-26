<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ProjectScenarioTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_scenarios()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $this->post($project->path() . '/scenarios', ['name' => 'Test scenario']);

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

        $scenario = factory('App\Scenario')->create(['name' => 'Test scenario']);

        $this->patch($scenario->path(), ['name' => 'Updated'])
            ->assertStatus(403);

        $this->assertDatabaseHas('scenarios', ['name' => 'Test scenario']);
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
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());
        $scenario = $project->addScenario('Lorem ipsum');

        $this->patch($scenario->path(), ['name' => 'Updated scenario name'])
            ->assertSessionHasNoErrors();

        $this->assertEquals('Updated scenario name', $project->scenarios()->first()->name);

        $this->assertDatabaseHas('scenarios', [
            'name' => 'Updated scenario name'
        ]);
    }

    /** @test */
    public function a_scenario_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());
        $scenario = $project->addScenario('Lorem ipsum');

        $this->assertDatabaseHas('scenarios', ['name' => 'Lorem ipsum']);

        $this->delete($scenario->path());

        $this->assertDatabaseMissing('scenarios', ['name' => 'Lorem ipsum']);
    }
}
