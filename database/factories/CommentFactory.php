<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
*/
class CommentFactory extends Factory
{
	/**
	* Define the model's default state.
	*
	* @return array<string, mixed>
	*/
	public function definition(): array
	{
		$posts = DB::table('posts')->where('status', 'Published')->get(['id', 'created_at']);

		$postIdsCreatedAt = [];
		
		foreach($posts as $post)
			$postIdsCreatedAt[$post->id] = $post->created_at;
		
		$postId = fake()->randomKey($postIdsCreatedAt);
		
		return [
			'post_id' => $postId,
			'user_id' => fake()->numberBetween(1, 5),
			'comment' => fake()->paragraph(rand(1, 6)),
			'created_at' => fake()->dateTimeBetween($postIdsCreatedAt[$postId])
		];
	}
}
