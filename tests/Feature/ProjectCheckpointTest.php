<?php

namespace Tests\Feature;

use App\Checkpoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectCheckpointTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function a_project_can_have_checkpoints()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/checkpoints', ['name' => 'Test checkpoint'])
            ->assertRedirect($project->path());

        $this->get($project->path())->assertSee('Test checkpoint');
        $this->assertDatabaseHas('checkpoints', ['name' => 'Test checkpoint']);
    }

    /** @test */
    public function a_scenario_can_have_checkpoints()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)
            ->withScenarios(1)
            ->ownedBy(auth()->user())
            ->create();
        $scenario = $project->scenarios->first();

        $start = Checkpoint::factory()->create(['name' => 'Start']);
        $end = Checkpoint::factory()->create();

        $scenario->addCheckpoints(collect([$start, $end]));

        $this->assertCount(2, $scenario->checkpoints);
        $this->assertEquals('Start', $scenario->checkpoints[0]->name);
    }

    /** @test */
    public function checkpoints_can_have_a_position_and_rotation()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();

        $checkpoint = Checkpoint::factory()->make([
            'name' => 'Some checkpoint',
            'position' => [
                $this->faker->randomFloat(),
                $this->faker->randomFloat(),
                $this->faker->randomFloat(),
            ],
            'rotation' => [
                $this->faker->randomFloat(),
                $this->faker->randomFloat(),
                $this->faker->randomFloat(),
            ],
        ])->attributesToArray();

        $this->post($project->path() . '/checkpoints', $checkpoint)->assertSessionDoesntHaveErrors();
        $this->assertEquals($checkpoint['position'], Checkpoint::first()->position);
        $this->assertEquals($checkpoint['rotation'], Checkpoint::first()->rotation);
    }

    /** @test */
    public function a_scenarios_related_checkpoints_are_ordered_by_sort_position()
    {
        $project = app(ProjectFactory::class)
            ->withScenarios(1)
            ->ownedBy(auth()->user())
            ->create();
        $scenario = $project->scenarios->first();

        $first = Checkpoint::factory()->create(['name' => 'First']);
        $second = Checkpoint::factory()->create(['name' => 'Second']);
        $third = Checkpoint::factory()->create(['name' => 'Third']);

        $scenario->addCheckpoints(collect([
            $third,
            $first,
            $second,
        ]));

        $this->assertCount(3, $scenario->checkpoints);
        $this->assertEquals('Third', $scenario->checkpoints[0]->name);
        $this->assertEquals('First', $scenario->checkpoints[1]->name);
        $this->assertEquals('Second', $scenario->checkpoints[2]->name);
    }

    /** @test */
    public function a_scenario_cannot_be_related_to_a_checkpoint_more_than_once()
    {
        $project = app(ProjectFactory::class)
            ->withScenarios(1)
            ->ownedBy(auth()->user())
            ->create();
        $scenario = $project->scenarios->first();

        $first = Checkpoint::factory()->create(['name' => 'First']);
        $second = Checkpoint::factory()->create(['name' => 'Second']);

        $scenario->addCheckpoints(collect([
            $second,
            $first,
            $second,
        ]));

        $this->assertCount(2, $scenario->checkpoints);
        $this->assertEquals('First', $scenario->checkpoints[0]->name);
        $this->assertEquals('Second', $scenario->checkpoints[1]->name);
    }
}
