<?php

namespace Database\Factories;

use App\Form;
use App\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Form::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'fields' => [
                [
                    'type' => 'header',
                    'template' => [
                        'text' => 'Some header text'
                    ],
                    'options' => [
                        'show_subtitle' => false,
                    ]
                ],
                ['type' => 'text', 'template' => ['text' => 'Some header text']],
                ['type' => 'new_section'],
                [
                    'type' => 'selection',
                    'template' => [
                        'question' => 'Question for selection',
                        'subtitle' => 'this is a subtitle',
                        'options' => ['option 1', 'option 2', 'option 3'],
                        'random_order' => false,
                        'dropdown' => false,
                        'show_subtitle' => false,
                        'required' => false,
                    ],
                ],
                [
                    'type' => 'evaluation',
                    'template' => [
                        'question' => 'Question for evaluation',
                        'subtitle' => 'this is a subtitle',
                        'scale_size' => 5,
                        'lower_bound_label' => 'small',
                        'upper_bound_label' => 'large',
                        'show_subtitle' => false,
                        'required' => false,
                        'show_labels' => true,
                    ]
                ]
            ]
        ];
    }
}
