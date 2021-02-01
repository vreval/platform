<?php

namespace Database\Factories;

use App\Checkpoint;
use App\Form;
use App\Scenario;
use App\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'scenario_id' => Scenario::factory(),
            'start_checkpoint_id' => Checkpoint::factory(),
            'start_form_id' => Form::factory(),
            'type_id' => $this->faker->numberBetween(1, 6)
        ];
    }
}
