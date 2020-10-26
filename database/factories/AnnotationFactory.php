<?php

namespace Database\Factories;

use App\Annotation;
use App\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnotationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Annotation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'description' => $this->faker->sentence
        ];
    }
}
