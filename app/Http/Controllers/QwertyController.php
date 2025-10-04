<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QwertyController extends Controller
{
    public $var = 'abc';

	public function xyz() {
		return view('page17');
	}

	public function abc(Request $request) {
		$name2 = $request->input('name2', 'Guest');
		
		return view('page18', ['name2' => $name2]);
	}

	public function abcd(Request $request) {
		echo $request->input('products.0.name');
		echo "\n";
		var_dump($request->input('products.*.price'));
		echo "\n";
		echo $request->input('user.name');
		echo "\n";
		echo $request->integer('user.name');
		echo "\n";
		var_dump($request->string('products.0.price'));
	}
}
