<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['name' => 'nikunj', 'surname' => 'bhatt', 'dob' => null]);
});
