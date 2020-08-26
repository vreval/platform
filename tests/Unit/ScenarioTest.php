<?php

namespace Tests\Unit;

use App\Project;
use App\Scenario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScenarioTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $scenario = factory(Scenario::class)->create();

        $this->assertInstanceOf(Project::class, $scenario->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $scenario = factory(Scenario::class)->create();

        $this->assertEquals('/projects/' . $scenario->project->id . '/scenarios/' . $scenario->id, $scenario->path());
    }
}
