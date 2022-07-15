<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(RoleSeeder::class);

        $this->call(UserSeeder::class);
        Game::factory(70)->create();
    }
}
