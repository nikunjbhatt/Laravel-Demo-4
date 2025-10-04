<?php

use App\Http\Controllers\AtoZController;
use App\Http\Controllers\QwertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User2Controller;
use App\Http\Controllers\User3Controller;

use App\Http\Middleware\MidWare1;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Redirect;

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

Route::get('u/{id}', [UserController::class, 'show']);
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
