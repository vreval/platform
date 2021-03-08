<?php

namespace Tests\Unit;

use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

//use PHPUnit\Framework\TestCase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_type()
    {
        Artisan::call('db:seed', ['--class' => 'TaskTypeSeeder']);

        $task = Task::factory()->create([
            'type_id' => 1,
            'position' => 1
        ]);

        $this->assertEquals('Annotation', $task->type_name);
    }

    /** @test */
    public function it_has_settings_depending_on_the_type()
    {
        Artisan::call('db:seed', ['--class' => 'TaskTypeSeeder']);

        $annotation = Task::factory()->create([
            'type_id' => 1,
            'position' => 1,
            'settings' => [
                'description' => "Pointing description",
                'start_checkpoint_id' => null,
                'start_form_id' => null,
                'count' => 3,
            ]
        ]);

        $pointing = Task::factory()->create([
            'type_id' => 2,
            'position' => 2
        ]);

        $this->assertEquals($annotation->attributesToArray(), Task::find(1)->attributesToArray());
        $this->assertEquals(3, $annotation->settings()->count);
        $this->assertEquals("Pointing task description", $pointing->settings()->description);
    }

    /** @test */
    public function it_saves_the_complete_task_including_settings()
    {
        Artisan::call('db:seed', ['--class' => 'TaskTypeSeeder']);

        $project = app(ProjectFactory::class)
            ->withScenarios(1)
            ->withCheckpoints(1)
            ->withForms(1)
            ->ownedBy($this->signIn())
            ->create();
        $project->save();

        // Add task using eloquent model scenario
        $scenario = $project->scenarios()->first();
        $checkpoint = $project->checkpoints()->first();
        $form = $project->forms()->first();

        $taskConfig = [
            'type_id' => 1,
            'start_checkpoint_id' => $checkpoint->id,
            'start_form_id' => $form->id,
        ];
        $task = $scenario->tasks()->make($taskConfig);

        $this->post($scenario->path() . '/tasks', ['tasks' => [$task->attributesToArray(), $task->attributesToArray()]])->assertSessionHasNoErrors();
        $this->assertCount(2, Task::all());
        $this->assertEquals($task->settings, Task::find(1)->settings);
        $this->assertEquals(0, Task::find(1)->position);
        $this->assertEquals(1, Task::find(2)->position);

        $this->post($scenario->path() . '/tasks', ['tasks' => [$task->attributesToArray()]])->assertSessionHasNoErrors();
        $this->assertCount(1, Task::all());
    }
}
