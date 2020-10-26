<?php

namespace Tests\Unit;

use App\Annotation;
use App\Form;
//use PHPUnit\Framework\TestCase;
use App\Pointing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
    public function it_has_a_form()
    {
        $form = Form::factory()->create();

        $annotation = Annotation::factory()->create();
        $annotation->assignTo($form);
        $this->assertEquals($form->id, $annotation->form->id);

        $pointing = Pointing::factory()->create();
        $pointing->assignTo($form);
        $this->assertEquals($form->id, $pointing->form->id);
    }
}
