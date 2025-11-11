<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
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

	public function listing($orderBy = 'id,asc')
	{
		list($field, $order) = explode(',', $orderBy);

		$field = match($field) {
			'u.id', 'u.name', 'u.email', 'u.created_at', 'u.updated_at', 'posts_count', 'comments_count' => $field,
			default => 'u.id'
		};

		$order = match($order) {
			'asc', 'desc' => $order,
			default => 'asc'
		};

		$users = DB::table('users AS u')
			->leftJoin('posts AS p', 'p.user_id', '=', 'u.id')
			->whereNull('u.deleted_at')
			->whereNull('p.deleted_at')
			->orderBy($field, $order)
			->groupBy('p.user_id')
			->select(['u.id', 'name', 'email', 'u.created_at', 'u.updated_at', DB::raw('COUNT(p.user_id) posts_count')])
			->addSelect([
				'comments_count' => function(Builder $builder) {
					$builder->select(DB::raw('COUNT(c.user_id)'))
						->from('comments AS c')
						->whereRaw('c.user_id = u.id')
						->whereNull('c.deleted_at')
						->groupBy('c.user_id');
				}
			])
			->get();
		
		return view('db.users', ['users' => $users, 'orderBy' => ['field' => $field, 'order' => $order]]);
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

		DB::transaction(function() use ($id, $validatedData) {
			DB::table('users')->where('id', $id)->update($validatedData);
		});

		return response()->redirectToRoute('db.users-list')->with('update', 'User details updated in the database.');
	}

	public function delete($id)
	{
		DB::beginTransaction();
		
		try {
			DB::table('users')->where('id', $id)->update(['deleted_at' => now()]);
			DB::commit();
		}
		catch(\Exception $ex) {
			DB::rollBack();
		}
		return response()->redirectToRoute('db.users-list')->with('delete', "User's record deleted from the database.");
	}
}
