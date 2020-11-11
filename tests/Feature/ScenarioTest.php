<?php

namespace Tests\Feature;

use App\Checkpoint;
use App\Project;
use App\Scenario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ScenarioTest extends TestCase
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
    public function only_the_owner_or_members_of_a_project_can_add_scenarios()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/scenarios', ['name' => 'Test scenario'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('scenarios', ['name' => 'Test scenario']);
    }

    /** @test */
    public function only_the_owner_or_members_of_a_project_can_update_a_scenario()
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

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $scenario = Scenario::factory()->raw(['name' => '']);

        $this->post($project->path() . '/scenarios', $scenario)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_scenario_can_have_a_description()
    {
        $user = $this->signIn();

        $project = app(ProjectFactory::class)->ownedBy($user)->create();

        $scenario = Scenario::factory()->make([
            'project_id' => $project->id,
            'name' => 'Test Name',
            'description' => 'Test Description'
        ]);

        $this->post($project->path() . '/scenarios', $scenario->attributesToArray())->assertSessionDoesntHaveErrors();

        $this->assertEquals('Test Description', Scenario::first()->description);
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
    public function project_owners_and_members_can_delete_their_scenarios()
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

    /** @test */
    public function checkpoints_can_be_included_during_scenario_creation()
    {
        $user = $this->signIn();

        $project = app(ProjectFactory::class)
            ->ownedBy($user)
            ->withCheckpoints(3)
            ->create();

        $scenario = Scenario::factory()->make([
            'project_id' => $project->id,
            'checkpoints' => [
                $project->checkpoints[1]->attributesToArray(),
                $project->checkpoints[2]->attributesToArray(),
                $project->checkpoints[0]->attributesToArray()
            ]
        ])->attributesToArray();

        $this->post($project->path() . '/scenarios', $scenario)->assertSessionDoesntHaveErrors();

        $checkpoints = Scenario::first()->checkpoints;

        $this->assertCount(3, $checkpoints);
        $this->assertEquals(2, $checkpoints[0]->pivot->checkpoint_id);
        $this->assertEquals(3, $checkpoints[1]->pivot->checkpoint_id);
        $this->assertEquals(1, $checkpoints[2]->pivot->checkpoint_id);
    }

    /** @test */
    public function checkpoints_relation_can_be_updated()
    {
        $user = $this->signIn();

        $project = app(ProjectFactory::class)
            ->ownedBy($user)
            ->withScenarios(1)
            ->withCheckpoints(3)
            ->create();

        $scenario = $project->scenarios()->first();

        $this->assertCount(3, $project->checkpoints);
        $this->assertCount(0, $scenario->checkpoints);

        $updatedScenarioData = $scenario->attributesToArray();
        $updatedScenarioData['checkpoints'] = [
            $project->checkpoints[1]->attributesToArray(),
            $project->checkpoints[2]->attributesToArray(),
            $project->checkpoints[0]->attributesToArray(),
        ];

        $this->patch($project->path() . '/scenarios/' . $scenario->id, $updatedScenarioData)
            ->assertSessionDoesntHaveErrors();

        $checkpoints = $project->scenarios()->first()->checkpoints;

        $this->assertCount(3, $checkpoints);
        $this->assertEquals(2, $checkpoints[0]->pivot->checkpoint_id);
        $this->assertEquals(3, $checkpoints[1]->pivot->checkpoint_id);
        $this->assertEquals(1, $checkpoints[2]->pivot->checkpoint_id);
    }

    /** @test */
    public function tasks_can_be_added()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $project = app(ProjectFactory::class)
            ->ownedBy($user)
            ->withScenarios(1)
            ->create();
        $scenario = $project->scenarios()->first();

        $this->post($scenario->path() . '/tasks', [
            'start_checkpoint_id' => 1,
            'start_form_id' => 1,
            'type_id' => 1,
            'settings' => [],
        ]);

        $this->assertCount(1, $scenario->tasks);
    }
}
