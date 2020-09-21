<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $user = $this->signIn();

        $project = factory(Project::class)->create();
        $project->user = $user;

        $this->assertInstanceOf(User::class, $project->activity->first()->user);
    }
}
