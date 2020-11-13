<?php

namespace Tests\Unit;

use App\Task;
use App\TaskType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
//use PHPUnit\Framework\TestCase;
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

        $this->assertEquals('annotation', $task->type_name);
    }
}
