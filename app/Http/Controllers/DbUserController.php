<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DbUserController extends Controller
{
	public function insert(Request $request)
	{
		$validatedData = Validator::validate($request->all(), [
			'name' => 'required|string',
			'email_address' => 'required|email|unique:users,email',
			'password' => 'required|min:6|confirmed',
		]);

		DB::insert('insert into users (name, email, password, created_at) values (?, ?, ?, ?)', [
			$validatedData['name'],
			$validatedData['email_address'],
			Hash::make($validatedData['password']),
			now()
		]);

		return back()->with('insert', 'Record inserted.');
	}

	public function listing($msgArray = [])
	{
		$users = DB::table('users')
			->whereNull('deleted_at')
			->get(['id', 'name', 'email', 'created_at', 'updated_at']);
		
		\Log::debug($msgArray);
		return view('db.users', ['users' => $users])->with($msgArray);
	}

	public function edit($id)
	{
		$user = DB::table('users')
			->where('id', $id)
			->get(['id', 'name', 'email']);
		
		if(!count($user))
			abort(404, 'No user not found having the supplied id.');
		
		return view('db.user', ['user' => $user[0]]);
	}

	public function update(Request $request, $id)
	{
		$validatedData = Validator::validate($request->all(), [
			'name' => 'required|string',
			'email_address' => [
				'required',
				'email',
				Rule::unique('users', 'email')->ignore($id)
			]
		]);

		if($request->password != '') {
			$validatedPassword = Validator::validate([$request->password], [
				'password' => 'min:6|confirmed',
			]);

			array_merge($validatedData, $validatedPassword);
		}

		$validatedData['email'] = $validatedData['email_address'];
		unset($validatedData['email_address']);

		$validatedData['updated_at'] = now();

		DB::table('users')->where('id', $id)->update($validatedData);

		return $this->listing(['update' => 'User details updated in the database.']);
	}
}
