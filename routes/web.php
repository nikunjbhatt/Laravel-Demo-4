<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

Route::get('/', function () {
    return view('welcome', ['name' => 'nikunj', 'surname' => 'bhatt', 'dob' => null]);
});

Route::view('/page1', 'page1');

Route::get('/page2', function () {
	return view('page2');
});

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
