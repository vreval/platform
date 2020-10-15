<?php

namespace Tests\Feature;

use App\Form;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_forms()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $project = app(ProjectFactory::class)->ownedBy($user)->create();

        $formAttributes = Form::factory()->make([
            'name' => 'Some form',
            'description' => 'Some description'
        ])->attributesToArray();

        $this->post($project->path() . '/forms', $formAttributes)
            ->assertRedirect($project->path());

        $this->assertEquals('Some form', Form::first()->name);
        $this->assertEquals('Some description', Form::first()->description);
    }

    /** @test */
    public function a_user_can_edit_a_form()
    {
        $user = $this->signIn();

        $project = app(ProjectFactory::class)->ownedBy($user)->create();
        $form = Form::factory()->create(['project_id' => $project->id]);

        $this->patch($project->path() . '/forms/' . $form->id, ['name' => 'Updated']);

        $this->assertEquals('Updated', $form->fresh()->name);
    }

    /** @test */
    public function users_cannot_edit_forms_of_others()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)->withForms(1)->create();
        $form = $project->forms->first();

        $this->patch($project->path() . '/forms/' . $form->id, ['name' => 'Updated'])
            ->assertStatus(403);

        $this->assertNotEquals('Updated', $form->fresh()->name);
    }

    /** @test */
    public function users_can_create_forms_including_fields()
    {
//        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $project = app(ProjectFactory::class)->ownedBy($user)->create();
        $formAttributes = Form::factory()->make([
            'fields' => [
                ['type' => 'header', 'template' => ['text' => 'Some text']],
                ['type' => 'hello', 'template' => ['text' => 'Some text']],
            ]
        ])->attributesToArray();

        $this->post($project->path() . '/forms', $formAttributes)
//            ->dumpSession();
            ->assertSessionHasErrors('fields.1.type');

//        $this->assertCount(1, Form::first()->fields);
    }
}
