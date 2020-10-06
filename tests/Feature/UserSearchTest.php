<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;
use Tests\TestCase;

class UserSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function searching_a_user_returns_a_collection ()
    {
        $this->signIn();

        $names = [ 'John', 'Sally', 'Nick', 'Johannes', 'Johna', 'Kally' ];
        foreach($names as $name) {
            User::factory()->create(['name' => $name]);
        }

        $response = $this->get('/users?search=Ni');
        $this->assertCount(1, $response['search_result']);

        $response = $this->get('/users?search=ally');
        $this->assertCount(2, $response['search_result']);

        $response = $this->get('/users?search=Joh');
        $this->assertCount(3, $response['search_result']);
    }
}
