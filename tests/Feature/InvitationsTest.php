<?php

namespace Tests\Feature;

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
        $project = app(ProjectFactory::class)->create();

        $project->invite($newUser = factory(User::class)->create());

        $this->signIn($newUser);
        $this->post(action('ProjectScenariosController@store', $project), $scenario = ['name' => 'Foo scenario']);

        $this->assertDatabaseHas('scenarios', $scenario);
    }
}
