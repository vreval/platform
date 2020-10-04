<?php

namespace Tests\Unit;

use App\Checkpoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckpointTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_has_an_is_positioned_flag()
    {
        $checkpoint = Checkpoint::factory()->create(['position' => null]);

        $this->assertFalse($checkpoint->isPositioned());

        $checkpoint->position = [
            $this->faker->randomFloat(),
            $this->faker->randomFloat(),
            $this->faker->randomFloat(),
        ];

        $this->assertTrue($checkpoint->isPositioned());
    }
}
