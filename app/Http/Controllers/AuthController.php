<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$cred = $request->validate([
			'email' => 'required|email',
			'password' => 'required|min:6'
		]);

		$rememberLogin = false;

		if($request->input('remember_login'))
			$rememberLogin = true;

		if(Auth::attempt($cred, $rememberLogin)) {
			$request->session()->regenerate();
			return redirect()->intended('dashboard');
		}

		return back()
			->withErrors([
				'email' => 'Incorrect login credentials.'
			])
			->onlyInput('email');
	}
}
