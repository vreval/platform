<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_projects()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function has_accessible_projects()
    {
        $john = $this->signIn();

        app(ProjectFactory::class)->ownedBy($john)->create();

        $this->assertCount(1, $john->availableProjects());

        $sally = User::factory()->create();
        $nick = User::factory()->create();

        $project = tap(app(ProjectFactory::class)->ownedBy($sally)->create())->invite($nick);
        $this->assertCount(1, $john->availableProjects());

        $project->invite($john);
        $this->assertCount(2, $john->availableProjects());
    }
}
