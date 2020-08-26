<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectManagementTests extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $response = $this->post('/projects', $attributes);

        $response->assertRedirect(Project::first()->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['name']);
    }

    /** @test */
    public function a_user_can_update_their_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(), ['name' => 'Updated']);

        $this->assertDatabaseHas('projects', ['name' => 'Updated']);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->name);
    }

    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->patch($project->path(), ['name' => 'Updated'])->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path(), ['name' => 'Updated'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('projects', ['name' => 'Updated']);
    }

    /** @test */
    public function a_project_requires_a_name()
    {
        $this->signIn();

        $this->post('/projects', factory('App\Project')->raw(['name' => '']))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_project_name_must_have_at_least_3_characters()
    {
        $this->actingAs(factory('App\User')->create());
        $this->signIn();

        $this->post('/projects', factory('App\Project')->raw(['name' => str_repeat('?', 2)]))
            ->assertSessionHasErrors('name');

        $this->post('/projects', factory('App\Project')->raw(['name' => str_repeat('?', 3)]))
            ->assertSessionDoesntHaveErrors('name');
    }

    /** @test */
    public function a_project_name_must_have_at_most_150_characters()
    {
        $this->actingAs(factory('App\User')->create());
        $this->signIn();

        $this->post('/projects', factory('App\Project')->raw(['name' => str_repeat('?', 151)]))
            ->assertSessionHasErrors('name');

        $this->post('/projects', factory('App\Project')->raw(['name' => str_repeat('?', 150)]))
            ->assertSessionDoesntHaveErrors('name');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());
        $this->signIn();

        $this->post('/projects', factory('App\Project')->raw(['description' => '']))
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_project_description_must_have_at_least_3_characters()
    {
        $this->actingAs(factory('App\User')->create());
        $this->signIn();

        $this->post('/projects', factory('App\Project')->raw(['description' => str_repeat('?', 2)]))
            ->assertSessionHasErrors('description');

        $this->post('/projects', factory('App\Project')->raw(['description' => str_repeat('?', 3)]))
            ->assertSessionDoesntHaveErrors('description');
    }

    /** @test */
    public function a_project_description_must_have_at_most_500_characters()
    {
        $this->actingAs(factory('App\User')->create());
        $this->signIn();

        $this->post('/projects', factory('App\Project')->raw(['description' => str_repeat('?', 501)]))
            ->assertSessionHasErrors('description');

        $this->post('/projects', factory('App\Project')->raw(['description' => str_repeat('?', 500)]))
            ->assertSessionDoesntHaveErrors('description');
    }
}
