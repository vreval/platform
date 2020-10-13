<?php

namespace Tests\Feature;

use App\Form;
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
        $user = $this->signIn();

        $project = app(ProjectFactory::class)->ownedBy($user)->create();

        $formAttributes = Form::factory()->make(['name' => 'Some form'])->attributesToArray();

        $this->post($project->path() . '/forms', $formAttributes);

        $this->assertEquals('Some form', Form::first()->name);
    }
}
