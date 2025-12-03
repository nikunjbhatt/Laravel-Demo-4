<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
	use WithoutModelEvents;
	
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		/*for($a = 0; $a < 10; $a++) {
			DB::table('users')->insert([
				'name' => fake()->name(),
				'email' => fake()->safeEmail(),
				'password' => Hash::make('123456'),
				'created_at' => now()
			]);
		}*/

		User::factory(5)
			//->count(5);
			->create();
    }
}
