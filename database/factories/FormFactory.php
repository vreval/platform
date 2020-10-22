<?php

namespace Database\Factories;

use App\Form;
use App\helpers\FormFieldFactory;
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
        $fieldFactory = new FormFieldFactory;
        return [
            'project_id' => Project::factory(),
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'fields' => [
                $fieldFactory->makeHeader(),
                $fieldFactory->makeText(),
                $fieldFactory->makeSection(),
                $fieldFactory->makeSelection(),
                $fieldFactory->makeRating(),
            ]
        ];
    }
}
