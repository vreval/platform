<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectScenariosController;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_owners_may_not_invite_users()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $assertInvitationForbidden = function () use ($user, $project) {
            $this
                ->actingAs($user)
                ->post($project->path() . '/invitations')
                ->assertStatus(403);
        };

        $assertInvitationForbidden();

        $project->invite($user);

        $assertInvitationForbidden();
    }

    /** @test */
    public function a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = Project::factory()->create();

        $userToInvite = User::factory()->create();

        $this
            ->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => $userToInvite->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function the_invited_email_address_must_be_associated_with_a_valid_vreval_account()
    {
        $project = Project::factory()->create();

        $this
            ->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'notauser@example.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a VREVAL account.'
            ], null, 'invitations');
    }

    /** @test */
    public function invited_users_can_update_project_details()
    {
        $project = Project::factory()->create();

        $project->invite($newUser = User::factory()->create());

        $this
            ->actingAs($newUser)
            ->post(action([ProjectScenariosController::class, 'store'], $project), $scenario = ['name' => 'Foo scenario']);

        $this->assertDatabaseHas('scenarios', $scenario);
    }
}
