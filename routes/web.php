<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

Route::get('/', function () {
    return view('welcome', ['name' => 'nikunj', 'surname' => 'bhatt', 'dob' => null]);
});
Route::get('/page1', function () {
	return view('page1');
});
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
	echo 'Hi ' . request('name');
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
