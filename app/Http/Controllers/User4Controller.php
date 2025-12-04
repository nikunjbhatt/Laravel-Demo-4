<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class User4Controller extends Controller
{
    public function listing()
	{
		$users = User::addSelect(
			DB::raw('(select count(id) from posts p where p.user_id = users.id) posts_count'),
			DB::raw('(select count(id) from comments c where c.user_id = users.id) comments_count')
		)
		->orderBy('name')
		->get();

		//return view('model.users', ['users' => User::all()]);
		return view('model.users', ['users' => $users]);
	}

	public function create(Request $request)
	{
		DB::transaction(function() use ($request) {
			User::create($request->all());
		});
	}

	public function edit($id)
	{
		$user = User::find($id);
		return view('model.user', ['user' => $user]);
	}

	public function update(Request $request, $id)
	{
		$user = User::find($id);

		if($request->password == '')
			$user->update($request->except('password'));
		else
			$user->update($request->all());
	}
}
