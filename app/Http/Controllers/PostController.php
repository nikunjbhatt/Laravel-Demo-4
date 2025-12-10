<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
	public function listing($userId)
	{
		$posts = Post::withCount('comments')
			->where('posts.user_id', $userId)
			->get();

		return view('model.posts', ['posts' => $posts]);	
	}
}
