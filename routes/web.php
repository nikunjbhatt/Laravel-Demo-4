<?php

use App\Http\Controllers\AtoZController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DbUserController;
use App\Http\Controllers\QwertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User2Controller;
use App\Http\Controllers\User3Controller;
use App\Http\Controllers\User4Controller;
use App\Http\Middleware\MidWare1;
use App\Http\Controllers\PostController;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome', ['name' => 'nikunj', 'surname' => 'bhatt', 'dob' => null]);
});

Route::view('/page1', 'page1')->name('page1');

Route::get('/page2', function () {
	return view('page2');
})->name('page2');

Route::get('/form', function () {
	return view('form');
});
Route::post('/form', function () {
	echo 'Hello ' . request('name');
});
Route::post('/form2', function() {
	return 'Hi ' . request('name');
})->name('form2');
Route::delete('/form3', function() {
	return Blade::render('form method is {{ $method }}', ['method' => request()->method()]);
})->name('form3');
Route::post('/form4', function() {
	return view('welcome', ['name' => 'nikunj', 'surname' => 'bhatt', 'dob' => null])->fragment('fragment1');
})->name('form4');
Route::post('/form5', function() {
	return view('welcome', ['name' => 'nikunj', 'surname' => 'bhatt', 'dob' => null])->fragments(['fragment1', 'fragment2']);
})->name('form5');

Route::redirect('/page3', '/page2');
Route::permanentRedirect('/page4', '/page2');
Route::redirect('/page5', '/page2', 301);

Route::any('/page2', function () {
	return view('page2');
});

Route::match(['get', 'post'], '/page1', function() {
	return view('page1');
});

Route::get('/page6/{user_id}', function($id) {
	return 'supplied parameter user_id: ' . $id;
});
Route::get('/page7/{user_id}/payments/{paymentId}', function($userId, $paymentId) {
	return "supplied parameters user_id: $userId , payment id: $paymentId";
});
Route::get('/page8/{userId?}', function($userId = -1) {
	return "user id: $userId";
});
Route::get('/page9/{userId}/{firstName?}', function($userId, $firstName = 'Nikunj') {
	return "user id: $userId, first name: $firstName";
})->where(['userId' => '[0-9]+', 'firstName' => '[A-Za-z]+']);
Route::get('/page10/{userId}/{firstName?}', function($userId, $firstName = 'Nikunj') {
	return "user id: $userId, first name: $firstName";
})->whereNumber('userId')->whereAlpha('firstName');
Route::get('/page11/{userId}', function($userId) {
	return "user id: $userId";
})->whereIn('userId', [1, 99, 888, 'abc', 'xyz']);

Route::view('/page12', 'page12');
Route::get('/page13', function() {
	return view('page13');
})->name('page13');

Route::get('/page14/{param?}', function($param = '') {
	return view('page14');
})->name('page14');

Route::prefix('pages')->name('pages.')->middleware(['web', 'api'])->group(function() {
	Route::get('/page15', function() {
		return view('page15');
	})->name('page15');
	Route::get('/page16', function() {
		return view('page16');
	})->name('page16');
});

Route::view('/user-not-found', 'user.not-found')->name('user-not-found');

Route::prefix('user')->name('user.')->group(function() {
	Route::get('id/{user}', function(User $user) {
		return $user->name . ' , ' . $user->email;
	})->whereNumber('user'); //->withTrashed();

	Route::get('name/{user:name}', function(User $user) {
		return $user->id . ' , ' . $user->email;
	})
		->whereAlpha('user')
		//->withTrashed();
		->missing(function() {
	        return Redirect::route('user-not-found');
    	});
});

Route::fallback(function() {
	return view('not-found');
});

Route::get('u/{id}', [UserController::class, 'show'])->middleware(['auth', 'verified']);
//Route::get('u/{id}', 'App\Http\Controllers\UserController@show');

Route::get('/atoz', AtoZController::class);
Route::resource('user2', User2Controller::class);
Route::resource('user2', User2Controller::class)->only('store')->middleware(MidWare1::class);

Route::middleware(MidWare1::class)->group(function() {
	Route::get('user3', [User3Controller::class, 'show']);
	Route::get('user3/create', [User3Controller::class, 'create'])->name('user3.create')->withoutMiddleware(MidWare1::class);
	Route::post('user3', [User3Controller::class, 'store'])->name('user3.store');
});

Route::get('/path/{param}', function(Request $request) {
	if($request->is('path/a*')) {
		return 'pattern matched: path/a*';
	}
	
	return $request->path();
});

Route::get('/page17', [QwertyController::class, 'xyz'])->name('page17-xyz');
Route::any('/page18', [QwertyController::class, 'abc'])->name('page18-abc');
Route::post('/page19', [QwertyController::class, 'abcd'])->name('page19-abcd');

Route::get('/page20', [QwertyController::class, 'a20_get'])->name('page20-get');
Route::post('/page20', [QwertyController::class, 'a20_post']);
Route::get('/page21', [QwertyController::class, 'a21_get']);
Route::get('/get-photo/{userId}', [QwertyController::class, 'getPhoto'])->whereNumber('userId')->name('get-photo');
Route::get('/page22', [QwertyController::class, 'a22_get']);

Route::get('/temp-file/{path}', function($path, Request $request) {
	/*if(!$request->hasValidSignature())
		abort(403);*/
	
    $file = \Storage::path($path);
    return response()->file($file);
})->where('path', '.*')->name('storage.local');

Route::get('/page23', function() {
	return ['a' => 1, 'b' => 2, 'c' => 3];
});
Route::get('/page24', function() { // supply parameters like ?&p1=a&p2=b&p3=c
	return request()->collect();
});
Route::get('/page25', function() { // supply parameters like ?&p1=a&p2=b&p3=c
	return response('Hello World', 200)
        ->header('X-My-Custom-Header', 'Nikunj Bhatt')
		->header('Page-Number', 25);
});
Route::get('/user/{userId}', function(User $user) { // supply parameters like ?&p1=a&p2=b&p3=c
	return $user;
});
Route::get('/page26', function() { // supply parameters like ?&p1=a&p2=b&p3=c
	\Cookie::expire('c2');

	return response('Hello World ' . request()->cookie('c1'), 200)
        ->withHeaders([
			'X-My-Custom-Header', 'Nikunj Bhatt',
			'Page-Number' => 26
		])
		; //->cookie('c1', 999, 11);
});
Route::get('/page28', [QwertyController::class, 'a28_get'])->name('page28');
//Route::view('/page27', 'page27')->middleware('cache.headers:public;max_age=20;etag');
Route::get('/page29', [QwertyController::class, 'a29_get']);
Route::view('/page30', 'page30')->name('page30');
Route::post('/page31', [QwertyController::class, 'a31_post'])->name('page31');
Route::get('/page32', [QwertyController::class, 'a32_get']);
Route::get('/page33', function() {
	return redirect()->away('https://laravel.com');
});
Route::get('/page34', function() {
	return redirect(route('page30'))->with('name', 'Vaishali');
});

Route::get('/page35', [QwertyController::class, 'a35_get']);
Route::get('/page36', [QwertyController::class, 'a36_get']);
Route::get('/page37', [QwertyController::class, 'a37_get']);
Route::get('/page38', [QwertyController::class, 'a38_get']);

Route::get('/page39', [QwertyController::class, 'a39_get']);
Route::get('/page40', function() {
	/*if(request()->hasValidSignature())
		echo 'signature is valid';
	else
		echo 'signature is invalid';
	*/
})->name('page40')->middleware('signed');
Route::get('/page41', [QwertyController::class, 'a41_get']);

Route::get('/page42', function() {
	return view('page42');
});
Route::post('/page42', [QwertyController::class, 'a42_post']);

Route::get('/page43', function() {
	return view('page43');
});
Route::post('/page43', [QwertyController::class, 'a43_post']);

Route::get('/log', function() {
	Log::alert('alert message');
	Log::critical('critical log message');
	Log::debug('debug log message');
	Log::emergency('emergency log message');
	Log::error('error log message');
	Log::info('info log message');
	Log::notice('info log message');
	Log::warning('warning log message');
	Log::warning(['array_key' => 'array_value']);
	Log::info('Value of a is: {a}', ['a' => 11]);
});

Route::prefix('db')->name('db.')->controller(DbUserController::class)->group(function() {
	Route::view('user/insert', 'db.user');
	Route::post('user/insert', 'insert')->name('user-insert');
	Route::get('users/{orderBy?}', 'listing')->name('users-list');
	Route::get('user/edit/{userId}', 'edit')->name('user-edit');
	Route::post('user/update/{userId}', 'update')->name('user-update');
	Route::delete('user/delete/{userId}', 'delete')->name('user-delete');
	
	Route::get('lateral-join', 'lateral_join'); // check this for MySQL database (not MariaDB)
	Route::get('union-query', 'union_query');
	Route::get('example-query', 'example_query');
	Route::get('comments/{offset?}', 'comments')->name('comments');
	Route::get('comments-pagination', 'comments_pagination');
});

Route::prefix('model')->name('model.')->group(function() {
	Route::get('users', [User4Controller::class, 'listing']);
	Route::view('user/create', 'model.user');
	Route::post('user/create', [User4Controller::class, 'create'])->name('user-create');
	Route::get('user/edit/{userId}', [User4Controller::class, 'edit'])->name('user-edit');
	Route::post('user/update/{userId}', [User4Controller::class, 'update'])->name('user-update');
	Route::get('user/{userId}/posts', [PostController::class, 'listing'])->name('user-posts');
});

Route::get('serialize', function() {
	$ar = [ 123, 45.67, null, 'a' => 'string', 'b' => null, [9, 8, 7]];
	echo serialize($ar);
});

Route::get('user-array', [User4Controller::class, 'user_array']);

Route::get('testing', function() {
	Session::put('session_key', 'session value');
	echo 'This is some text';
	//$user = User::find(3);
	return response('')->withHeaders([ 'X-Header-Name' => 'Nikunj' ]);
});

Route::get('login', function() {
	return view('auth.login');
})->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('dashboard', function() {
	return view('dashboard');
});

Route::get('logout', function(Request $request) {
	Auth::guard('web')->logout();
	$request->session()->invalidate();
	$request->session()->regenerateToken();
	return redirect('dashboard');
})->name('logout');

Route::get('forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('forgot-password', [AuthController::class, 'resetPassword1'])->middleware('guest')->name('password.email');

Route::get('reset-password/{token}', function(string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('reset-password', [AuthController::class, 'resetPassword2'])->middleware('guest')->name('password.update');

Route::get('encryption', function() {
	$encrypted = Crypt::encryptString('plain string');
	echo $encrypted . '<br><br>' . base64_decode($encrypted);
	$obj = json_decode(base64_decode($encrypted));
	echo '<br><br>' . base64_decode($obj->value);
	echo '<br><br>' . base64_decode($obj->iv);
	echo '<br><br>' . base64_decode($obj->mac);
	echo '<br><br>' . Crypt::decryptString($encrypted);
});

Route::get('hash', function() {
	$hashedValue = Hash::make('plain value');
	echo $hashedValue;

	if(Hash::check('plain value', $hashedValue))
		echo '<br>hashed value matched';
	else
		echo "<br>hashed value didn't matched";
});
