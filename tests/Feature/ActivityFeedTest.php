<?php

namespace Tests\Feature;

use App\Scenario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project_records_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->first()->description);
    }

    /** @test */
    public function updating_a_project_records_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $project->update(['name' => 'Updated']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_new_scenario_records_project_activity()
    {
        $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)->create();

        $project->addScenario('Some scenario');

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

        $scenario = $project->addScenario('Some scenario');

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

        $scenario = $project->addScenario('Some scenario');

        $scenario->delete();

        $this->assertCount(3, $project->activity);
        $this->assertEquals('scenario_deleted', $project->activity->last()->description);
    }
}
