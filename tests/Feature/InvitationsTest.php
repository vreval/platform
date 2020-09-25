<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectScenariosController;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = Project::factory()->create();

        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);
        $this->post(action([ProjectScenariosController::class, 'store'], $project), $scenario = ['name' => 'Foo scenario']);

        $this->assertDatabaseHas('scenarios', $scenario);
    }
}
