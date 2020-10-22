<?php

namespace Tests\Unit;

use App\Form;
use App\helpers\FormFieldFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fields()
    {
        $form = Form::factory()->create();

        $this->assertCount(5, $form->fields);
    }

    /** @test */
    public function it_can_add_header_fields()
    {
        $form = Form::factory()->create(['fields' => []]);

        $this->assertCount(0, $form->fields);

        $form->addHeader(['text' => 'Some header']);
        $form->addText(['text' => 'Some text']);
        $form->addSection();
        $form->addSelection([
            'question' => 'Question for selection',
            'subtitle' => 'this is a subtitle',
            'options' => ['option 1', 'option 2', 'option 3'],
            'random_order' => true,
            'dropdown' => false,
            'show_subtitle' => false,
            'required' => false,
        ]);
        $form->addRating([
            'question' => 'Question for evaluation',
            'subtitle' => 'this is a subtitle',
            'levels' => 3,
            'lower_bound_label' => 'small',
            'upper_bound_label' => 'large',
            'show_subtitle' => false,
            'required' => false,
            'show_labels' => true,
        ]);

        $this->assertCount(5, $form->fields);
        $this->assertEquals('Some header', $form->fields[0]['template']['text']);
        $this->assertEquals('Some text', $form->fields[1]['template']['text']);
        $this->assertEquals('section', $form->fields[2]['type']);
        $this->assertTrue($form->fields[3]['template']['random_order']);
        $this->assertEquals(3, $form->fields[4]['template']['levels']);
    }

    /** @test */
    public function form_field_factory_merges_field_options_into_defaults()
    {
        $fieldFactory = new FormFieldFactory();

        $field = $fieldFactory->makeRating([
            'required' => true,
            'show_labels' => false
        ]);

        $this->assertEquals([
            'type' => 'rating',
            'template' => [
                'question' => 'Question',
                'subtitle' => 'Subtitle',
                'levels' => 5,
                'lower_bound_label' => 'Label A',
                'upper_bound_label' => 'Label B',
                'show_subtitle' => false,
                'required' => true,
                'show_labels' => false,
            ]
        ], $field);
    }
}
