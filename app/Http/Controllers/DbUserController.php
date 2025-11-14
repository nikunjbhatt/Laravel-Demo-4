<?php

namespace App\Http\Controllers;

use App\Models\User;

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
			->firstOrFail(['id', 'name', 'email']);
		
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

	public function lateral_join()
	{
		$latestPosts = DB::table('posts')
			->select('id as post_id', 'title as post_title', 'created_at as post_created_at')
			->whereColumn('user_id', 'users.id')
			->orderBy('created_at', 'desc')
			->limit(3);

		$users = DB::table('users')
			->joinLateral($latestPosts, 'latest_posts')
			->get();

		return view('db.lateral-join', ['users' => $users]);
	}

	public function union_query()
	{
		$products = DB::table('products')
			->select([DB::raw("'Products' AS `table`"), 'id', 'name', 'size_unit AS extra', 'created_at', 'updated_at']);
		
		$usersProducts = DB::table('users')
			->select([DB::raw("'Users' AS `table`"), 'id', 'name', 'email AS extra', 'created_at', 'updated_at'])
			->union($products)
			->get();
		
		return view('db.union-query', ['usersProducts' => $usersProducts]);
	}

	public function query_examples()
	{
		DB::table('users')
			->where('votes', '>', 100)
			->orWhere(function (Builder $query) {
				$query->where('name', 'Abigail')
					->where('votes', '>', 50);
			});
		// where votes > 100 or (name = 'Abigail' and votes > 50)

		DB::table('products')
			->whereNot(function (Builder $query) {
				$query->where('clearance', true)
					->orWhere('price', '<', 10);
			});
		// where NOT (clearance = true or price < 10)

		DB::table('users')
			->where('active', true)
			->whereAny([
				'name',
				'email',
				'phone',
			], 'like', 'Example%');
		// where active = true and (name LIKE 'Example%' OR email LIKE 'Example%' OR phone LIKE 'Example%')

		DB::table('posts')
			->where('published', true)
			->whereAll([
				'title',
				'content',
			], 'like', '%Laravel%');
		// where published = true and (title like '%Laravel%' and content like '%Laravel%')

		DB::table('albums')
			->where('published', true)
			->whereNone([
				'title',
				'lyrics',
				'tags',
			], 'like', '%explicit%');
		// WHERE published = true AND NOT (title LIKE '%explicit%' OR lyrics LIKE '%explicit%' OR tags LIKE '%explicit%')

		// JSON
		DB::where('preferences->dining->meal', 'salad');
		// column preferences = { 'dining': { 'meal': 'salad' } }

		DB::whereIn('preferences->dining->meal', ['pasta', 'salad', 'sandwich']);

		DB::whereLike('name', '%John%');
		// where name like '%John%'

		DB::orWhereLike('name', '%John%');
		// where <other_condition> or name like '%John%'

		DB::whereNotLike('name', '%John%');
		// where name not like '%John%'

		DB::whereIn('id', [1, 2, 3]);
		// where id in (1, 2, 3)

		DB::whereNotIn('id', [1, 2, 3]);
		// where id NOT in (1, 2, 3)

		$activeUsers = DB::table('users')->select('id')->where('is_active', 1);
		DB::table('comments')
			->whereIn('user_id', $activeUsers)
			->get();
		// select * from comments where user_id in (select id from users where is_active = 1)

		DB::whereBetween('votes', [1, 100]);
		// where votes between 1 and 100

		DB::whereBetweenColumns('weight', ['minimum_allowed_weight', 'maximum_allowed_weight']);
		// where weight between minimum_allowed_weight and maximum_allowed_weight

		DB::whereValueBetween(100, ['min_price', 'max_price']);
		// where 100 between min_price and max_price

		DB::whereNull('updated_at');
		// where updated_at is null

		DB::whereColumn('first_name', 'last_name');
		// where first_name = last_name

		DB::table('users')
			->whereExists(function (Builder $query) {
				$query->select(DB::raw(1))
					->from('orders')
					->whereColumn('orders.user_id', 'users.id');
			});
		// OR
		$orders = DB::table('orders')
			->select(DB::raw(1))
			->whereColumn('orders.user_id', 'users.id');
		DB::table('users')
			->whereExists($orders);
		// select * from users where exists (select 1 from orders where orders.user_id = users.id)
	}

	public function example_query()
	{
		DB::table('users')
			->whereDate('created_at', '<', '2025-11-08')
			->whereMonth('created_at', 11)
			->whereDay('created_at', 8)
			->whereYear('created_at', 2025)
			->whereTime('created_at', '=', '12:34:56')
			//->get()
			;
		// where date(`created_at`) = '2025-11-08' and month(`created_at`) = '11' and day(`created_at`) = '08' and year(`created_at`) = 2025 and time(`created_at`) = '12:34:56'

		DB::table('users')
			->wherePast('created_at')
			->whereNowOrPast('created_at')
			->whereFuture('created_at')
			->whereNowOrFuture('created_at')
			->whereToday('created_at')
			->whereBeforeToday('created_at')
			->whereTodayOrBefore('created_at')
			->whereAfterToday('created_at')
			->whereTodayOrAfter('created_at')
			//->get()
			;
		// where `created_at` < '2025-11-14 18:45:01' and `created_at` <= '2025-11-14 18:45:01' and `created_at` > '2025-11-14 18:45:01' and `created_at` >= '2025-11-14 18:45:01' and date(`created_at`) = '2025-11-14' and date(`created_at`) < '2025-11-14' and date(`created_at`) <= '2025-11-14' and date(`created_at`) > '2025-11-14' and date(`created_at`) >= '2025-11-14'

		$r = User::where(function (Builder $query) {
				$query->select('status')
					->from('posts')
					->whereColumn('posts.user_id', 'users.id')
					->limit(1);
			}, 'Draft')
			//->get()
			;
		// select * from `users` where (select `status` from `posts` where `posts`.`user_id` = `users`.`id` limit 1) = 'Draft' and `users`.`deleted_at` is null
	}
}
