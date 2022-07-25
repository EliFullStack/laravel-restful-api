<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nickname' => 'Eli Alvarez',
            'email' => 'elialvarez@example.com',
            'email_verified_at' => now(),
            'role' => 1,
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);
        
        $user->assignRole('admin');

        

        User::factory(50)->create()->each(function($user) {
            $user->assignRole('user');
        });
    }
}
