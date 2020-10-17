<?php

namespace Tests\Feature;

use App\Form;
use App\helpers\FormFieldFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_forms()
    {
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
    public function form_fields_must_contain_a_type_with_a_valid_value()
    {
        $user = $this->signIn();

        $project = app(ProjectFactory::class)->ownedBy($user)->create();

        $formAttributes = Form::factory()->make([
            'fields' => [
                ['type' => 'header', 'template' => ['text' => 'Some text']],
                ['type' => 'text', 'template' => ['text' => 'Some text']],
                ['type' => 'section', 'template' => []],
                ['type' => 'selection', 'template' => []],
                ['type' => 'evaluation', 'template' => []],
            ]
        ])->attributesToArray();

        $this->post($project->path() . '/forms', $formAttributes)
            ->assertSessionHasNoErrors();

        $formAttributes = Form::factory()->make([
            'fields' => [
                ['type' => 'header', 'template' => []],
                ['type' => 'invalid_type', 'template' => []],
            ]
        ])->attributesToArray();

        $this->post($project->path() . '/forms', $formAttributes)
            ->assertSessionHasErrors('fields.1.type');
    }

    /** @test */
    public function users_cannot_create_forms_with_invalid_header_fields()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();
        $form = Form::factory()->make(['fields' => []]);
        $form->addHeader([
            'text' => 1234,
            'show_subtitle' => 'invalid input'
        ]);

        $this->post($project->path() . '/forms', $form->attributesToArray())
            ->assertSessionHasErrors([
                'fields.0.template.text',
                'fields.0.template.show_subtitle'
            ]);
        $this->assertCount(0, Form::all());
    }

    /** @test */
    public function users_cannot_create_forms_with_invalid_text_fields()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();
        $form = Form::factory()->make(['fields' => []]);
        $form->addText([ 'text' => 1234 ]);

        $this->post($project->path() . '/forms', $form->attributesToArray())
            ->assertSessionHasErrors([
                'fields.0.template.text'
            ]);
        $this->assertCount(0, Form::all());
    }

    /** @test */
    public function users_cannot_create_forms_with_invalid_selection_fields()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();
        $form = Form::factory()->make(['fields' => []]);
        $form->addSelection([
            'question' => 1234,
            'subtitle' => 1234,
            'options' => ['only one option'],
            'random_order' => 'invalid input',
            'dropdown'=> 'invalid input',
            'show_subtitle'=> 'invalid input',
            'required'=> 'invalid input',
            'multiple_choice'=> 'invalid input',
        ]);

        $this->post($project->path() . '/forms', $form->attributesToArray())
            ->assertSessionHasErrors([
                'fields.0.template.question',
                'fields.0.template.subtitle',
                'fields.0.template.options',
                'fields.0.template.random_order',
                'fields.0.template.dropdown',
                'fields.0.template.show_subtitle',
                'fields.0.template.required',
                'fields.0.template.multiple_choice',
            ]);
        $this->assertCount(0, Form::all());
    }

    /** @test */
    public function users_cannot_create_forms_with_invalid_evaluation_fields()
    {
        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->create();
        $form = Form::factory()->make(['fields' => []]);
        $form->addEvaluation([
            'question' => 1234,
            'subtitle' => 1234,
            'scale_size' => 1234,
            'lower_bound_label' => 1234,
            'upper_bound_label' => 1234,
            'show_labels'=> 'invalid input',
            'show_subtitle'=> 'invalid input',
            'required'=> 'invalid input',
        ]);

        $this->post($project->path() . '/forms', $form->attributesToArray())
            ->assertSessionHasErrors([
                'fields.0.template.question',
                'fields.0.template.subtitle',
                'fields.0.template.scale_size',
                'fields.0.template.lower_bound_label',
                'fields.0.template.upper_bound_label',
                'fields.0.template.show_labels',
                'fields.0.template.show_subtitle',
                'fields.0.template.required',
            ]);
        $this->assertCount(0, Form::all());
    }

    /** @test */
    public function users_can_include_fields_during_form_creation()
    {
        $user = $this->signIn();

        $project = app(ProjectFactory::class)->ownedBy($user)->create();

        $fieldFactory = new FormFieldFactory();
        $formAttributes = Form::factory()->make([
            'fields' => [
                $fieldFactory->makeHeader(),
                $fieldFactory->makeText(),
                $fieldFactory->makeSection(),
                $fieldFactory->makeSelection(),
                $fieldFactory->makeEvaluation(),
            ]
        ])->attributesToArray();

        $this->post($project->path() . '/forms', $formAttributes);

        $newForm = Form::first();
        $this->assertCount(5, $newForm->fields);
        $this->assertEquals('Header Text', $newForm->fields[0]['template']['text']);
        $this->assertEquals('Text Block', $newForm->fields[1]['template']['text']);
        $this->assertCount(3, $newForm->fields[3]['template']['options']);
        $this->assertEquals('Label A', $newForm->fields[4]['template']['lower_bound_label']);
    }

    /** @test */
    public function user_can_update_forms_and_their_fields()
    {
        $user = $this->signIn();

        $project = app(ProjectFactory::class)->withForms(3)->ownedBy($user)->create();
        $form = Form::find(1);

        $this->assertEquals('header', $form->fields[0]['type']);

        $fieldFactory = new FormFieldFactory();
        $formAttributes = Form::factory()->make([
            'fields' => [
                $fieldFactory->makeText(),
                $fieldFactory->makeSection(),
                $fieldFactory->makeSelection(),
                $fieldFactory->makeEvaluation(),
            ]
        ])->attributesToArray();

        $this->patch($project->path() . '/forms/' . $form->id, $formAttributes);

        $this->assertEquals('text', $form->fresh()->fields[0]['type']);
    }
}
