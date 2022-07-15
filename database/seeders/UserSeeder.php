<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

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
            'nickname' => 'Verito',
            'email' => 'verito@example.com',
            'password' => bcrypt('12345678')
        ]);

        $user->assignRole('admin');

        User::factory(50)->create();
    }
}
