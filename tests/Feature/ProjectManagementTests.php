<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectManagementTests extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
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

        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();

        $this->get($project->path() . '/edit')->assertStatus(200);

        $newAttributes = [
            'name' => 'Updated',
            'description' => 'Updated',
        ];

        $this->patch($project->path(), $newAttributes);

        $this->assertDatabaseHas('projects', $newAttributes);
    }

    /** @test */
    public function unauthorized_cannot_delete_a_project() {
        $project = app(ProjectFactory::class)->create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_a_project() {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->withScenarios(1)
            ->create();

        $this->get($project->path())
            ->assertSee($project->name);
    }

    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = app(ProjectFactory::class)->create();

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

        $project = app(ProjectFactory::class)->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)->create();

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
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();

        $project->name = str_repeat('?', 2);
        $this->post('/projects', $project->toArray())
            ->assertSessionHasErrors('name');

        $project->name = str_repeat('?', 3);
        $this->post('/projects', $project->toArray())
            ->assertSessionDoesntHaveErrors('name');
    }

    /** @test */
    public function a_project_name_must_have_at_most_150_characters()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();

        $project->name = str_repeat('?', 151);
        $this->post('/projects', $project->toArray())
            ->assertSessionHasErrors('name');

        $project->name = str_repeat('?', 150);
        $this->post('/projects', $project->toArray())
            ->assertSessionDoesntHaveErrors('name');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $this->post('/projects', factory('App\Project')->raw(['description' => '']))
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_project_description_must_have_at_least_3_characters()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();

        $project->description = str_repeat('?', 2);
        $this->post('/projects', $project->toArray())
            ->assertSessionHasErrors('description');

        $project->description = str_repeat('?', 3);
        $this->post('/projects', $project->toArray())
            ->assertSessionDoesntHaveErrors('description');
    }

    /** @test */
    public function a_project_description_must_have_at_most_500_characters()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();

        $project->description = str_repeat('?', 501);
        $this->post('/projects', $project->toArray())
            ->assertSessionHasErrors('description');

        $project->description = str_repeat('?', 500);
        $this->post('/projects', $project->toArray())
            ->assertSessionDoesntHaveErrors('description');
    }
}
