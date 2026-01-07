<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

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

	public function resetPassword1(Request $request)
	{
		$request->validate(['email' => 'required|email']);

		$status = Password::sendResetLink($request->only('email'));

		return $status === Password::ResetLinkSent
			? back()->with(['status' => __($status)])
			: back()->withErrors(['email' => __($status)]);
	}
	
	public function resetPassword2(Request $request)
	{
		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:6|confirmed',
		]);

		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function(User $user, string $password) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		return $status === Password::PasswordReset
			? redirect()->route('login')->with('status', __($status))
			: back()->withErrors(['email' => [__($status)]]);
	}
}
