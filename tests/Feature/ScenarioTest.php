<?php

namespace Tests\Feature;

use App\Checkpoint;
use App\Project;
use App\Scenario;
use App\Task;
use Database\Factories\TaskFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
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
    public function tasks_relation_can_be_updated()
    {
        Artisan::call('db:seed', ['--class' => 'TaskTypeSeeder']);
        $user = $this->signIn();

        $project = app(ProjectFactory::class)
            ->ownedBy($user)
            ->withScenarios(1)
            ->withCheckpoints(3)
            ->withForms(3)
            ->create();

        $scenario = $project->scenarios()->first();

        $updatedScenario1 = $scenario->attributesToArray();
        $tasksToAdd = Task::factory()->count(2)->make([
            'scenario_id' => 1,
            'start_checkpoint_id' => 1,
            'start_form_id' => 1,
        ]);

        $updatedScenario1['tasks'] = [
            $tasksToAdd[0]->attributesToArray(),
            $tasksToAdd[1]->attributesToArray()
        ];

        $this->patch($project->path() . '/scenarios/' . $scenario->id, $updatedScenario1)
            ->assertSessionDoesntHaveErrors();

        $tasks = $scenario->fresh()->tasks;

        $this->assertCount(2, $tasks);
        $this->assertEquals(1, $tasks[0]->position);
        $this->assertEquals(2, $tasks[1]->position);
        $this->assertEquals(1, $tasks[0]->id);
        $this->assertEquals(2, $tasks[1]->id);
        $this->assertTrue(is_array($tasks[0]->settings));
    }

    /** @test */
    public function tasks_can_be_added()
    {
        Artisan::call('db:seed', ['--class' => 'TaskTypeSeeder']);
        $user = $this->signIn();

        $project = app(ProjectFactory::class)
            ->ownedBy($user)
            ->withScenarios(1)
            ->withCheckpoints(3)
            ->withForms(3)
            ->create();
        $scenario = $project->scenarios()->first();

        $this->post($scenario->path() . '/tasks', [
            'fields' => [
                [
                    'start_checkpoint_id' => $project->checkpoints[1]->id,
                    'start_form_id' => $project->forms[1]->id,
                    'type_id' => 1,
                    'settings' => ['tracking_frequency' => 0.25]
                ],
                [
                    'start_checkpoint_id' => $project->checkpoints[0]->id,
                    'start_form_id' => $project->forms[0]->id,
                    'type_id' => 1,
                    'settings' => ['tracking_frequency' => 0.25]
                ],
                [
                    'start_checkpoint_id' => $project->checkpoints[2]->id,
                    'start_form_id' => $project->forms[2]->id,
                    'type_id' => 1,
                    'settings' => ['tracking_frequency' => 0.25]
                ],
            ]
        ])->assertSessionHasNoErrors();

        $this->assertCount(3, $scenario->fields);
        $this->assertEquals(0, $scenario->fields->first()->position);
        $this->assertEquals(2, $scenario->fields->last()->position);

        // Check the order
        $this->assertEquals(2, $scenario->taskAtPosition(0)->checkpoint->id);
        $this->assertEquals(3, $scenario->taskAtPosition(2)->checkpoint->id);

        $this->post($scenario->path() . '/tasks', [
            'fields' => [
                [
                    'start_checkpoint_id' => $project->checkpoints[1]->id,
                    'start_form_id' => $project->forms[1]->id,
                    'type_id' => 1,
                    'settings' => ['tracking_frequency' => 0.25]
                ],
                [
                    'start_checkpoint_id' => $project->checkpoints[0]->id,
                    'start_form_id' => $project->forms[0]->id,
                    'type_id' => 1,
                    'settings' => ['tracking_frequency' => 0.25]
                ],
            ]
        ]);
        $this->assertCount(2, $scenario->fresh()->fields);
    }

    /** @test */
    public function tasks_are_validated_correctly()
    {
        Artisan::call('db:seed', ['--class' => 'TaskTypeSeeder']);
        $user = $this->signIn();

        $project = app(ProjectFactory::class)
            ->ownedBy($user)
            ->withScenarios(1)
            ->withCheckpoints(1)
            ->withForms(1)
            ->create();
        $scenario = $project->scenarios()->first();

        $this->post($scenario->path() . '/tasks', [
            'fields' => [
                [
                    'start_checkpoint_id' => $project->checkpoints->first()->id,
                    'start_form_id' => $project->forms->first()->id,
                    'type_id' => 5,
                    'settings' => [
                        'max_walking_distance' => 100,
                        'tracking_interval' => 0.25
                    ]
                ],
            ]
        ])->assertSessionHasNoErrors();

        $this->assertEquals(1, $scenario->fresh()->fields->first()->checkpoint->id);
        $this->assertEquals(1, $scenario->fresh()->fields->first()->form->id);

        $this->post($scenario->path() . '/tasks', [
            'fields' => [
                [
                    'start_checkpoint_id' => $project->checkpoints->first()->id,
                    'start_form_id' => $project->forms->first()->id,
                    'type_id' => 7,
                    'settings' => [
                        'max_walking_distance' => 100,
                        'tracking_interval' => 0.25
                    ]
                ],
            ]
        ])->assertSessionHasErrors('fields.0.type_id');
    }
}
