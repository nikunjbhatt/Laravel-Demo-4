<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUser;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(string $id): View
    {
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }

	public function store()
	{
		$user = User::create([
			'name' => fake()->name(),
			'email' => fake()->email(),
			'password' => Hash::make('123456'),
			'gender' => fake()->randomElement(['M', 'F'])
		]);

		ProcessUser::dispatch($user);

		return response("User created, job added.<br>Run the job using \"php artisan queue:work\". You should find the inserted user's data as an object in the laravel.log file.");
	}
}
