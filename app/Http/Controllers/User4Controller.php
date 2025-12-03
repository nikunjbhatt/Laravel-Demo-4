<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class User4Controller extends Controller
{
    public function listing()
	{
		//return view('model.users', ['users' => User::all()]);
		return view('model.users', ['users' => User::orderBy('name')->get()]);
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
