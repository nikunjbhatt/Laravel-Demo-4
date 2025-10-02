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
}
