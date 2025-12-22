<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->postJson('/api/user3', [
			'name' => fake()->name(),
			'email' => fake()->safeEmail(),
			'gender' => fake()->randomElement(['M', 'F']),
			'password' => Hash::make('123456')
		]);

        $response->assertStatus(201)->assertJson(['created' => true]);
		$this->assertTrue($response['created']);
    }
}
