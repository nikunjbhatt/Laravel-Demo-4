<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
}
