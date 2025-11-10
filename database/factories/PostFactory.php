<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
*/
class PostFactory extends Factory
{
	/**
	* Define the model's default state.
	*
	* @return array<string, mixed>
	*/
	public function definition(): array
	{
		return [
			'user_id' => fake()->numberBetween(1, 5),
			'title' => fake()->sentence(8, true),
			'status' => fake()->randomElement(['Draft', 'Published']),
			'created_at' => fake()->dateTimeBetween('-1 month')
		];
	}
}
