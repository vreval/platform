<?php

namespace Tests\Feature;

use App\Scenario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project_records_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('project_created', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    /** @test */
    public function updating_a_project_records_activity()
    {
        $project = app(ProjectFactory::class)->create();
        $originalName = $project->name;

        $project->update(['name' => 'Updated']);

        $this->assertCount(2, $project->activity);
        tap($project->activity->last(), function ($activity) use ($originalName) {
            $this->assertEquals('project_updated', $activity->description);

            $expected = [
                'before' => ['name' => $originalName],
                'after' => ['name' => 'Updated']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function creating_a_new_scenario_records_project_activity()
    {
        $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)->create();

        $project->addScenario(['name' => 'Some scenario']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('scenario_created', $activity->description);
            $this->assertInstanceOf(Scenario::class, $activity->subject);
            $this->assertEquals('Some scenario', $activity->subject->name);
        });
    }

    /** @test */
    public function updating_a_scenario_records_project_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $scenario = $project->addScenario(['name' => 'Some scenario']);

        $scenario->update(['name' => 'Updated']);

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('scenario_updated', $activity->description);
            $this->assertInstanceOf(Scenario::class, $activity->subject);
            $this->assertEquals('Updated', $activity->subject->name);
        });
    }

    /** @test */
    public function deleting_a_scenario_records_project_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $scenario = $project->addScenario(['name' => 'Some scenario']);

        $scenario->delete();

        $this->assertCount(3, $project->activity);
        $this->assertEquals('scenario_deleted', $project->activity->last()->description);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('scenario_deleted', $activity->description);
        });
    }
}
