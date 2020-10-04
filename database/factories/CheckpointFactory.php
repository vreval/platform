<?php

namespace Database\Factories;

use App\Checkpoint;
use App\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckpointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Checkpoint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'name' => $this->faker->sentence(),
            'position' => [
                $this->faker->randomFloat(),
                $this->faker->randomFloat(),
                $this->faker->randomFloat(),
            ],
            'rotation' => [
                $this->faker->randomFloat(),
                $this->faker->randomFloat(),
                $this->faker->randomFloat(),
            ],
        ];
    }
}
