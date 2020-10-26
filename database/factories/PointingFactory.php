<?php

namespace Database\Factories;

use App\Pointing;
use App\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pointing::class;

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
