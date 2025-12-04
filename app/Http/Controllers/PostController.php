<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
	public function listing($userId)
	{
		$posts = Post::addSelect(
			DB::raw('posts.*'),
			DB::raw('(select count(id) from comments c where c.post_id = posts.id) comments_count')
		)
		->where('posts.user_id', $userId)
		->get();

		return view('model.posts', ['posts' => $posts]);	
	}
}
