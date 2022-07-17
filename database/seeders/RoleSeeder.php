<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        $averageSuccessRate = Permission::create(['name' => 'api.players.averageSuccessRate']);
        $showPlayerGames = Permission::create(['name' => 'api.players.showPlayerGames']);
        $updateName = Permission::create(['name' => 'api.players.updateName']);
        $destroyPlayerThrows = Permission::create(['name' => 'api.players.destroyPlayerThrows']);
        $throwDice = Permission::create(['name' => 'api.players.throwDice']);
        $getRanking = Permission::create(['name' => 'api.players.getRanking']);
        $getWinner = Permission::create(['name' => 'api.players.getWinner']);
        $getLoser = Permission::create(['name' => 'api.players.getLoser']);
        $login = Permission::create(['name' => 'api.login']);
        $logout = Permission::create(['name' => 'api.logout']);
        
        $admin->syncPermissions([
            $login,
            $logout,
            $showPlayerGames,
            $updateName,
            $destroyPlayerThrows,
            $throwDice,
            $averageSuccessRate, 
            $getRanking,
            $getWinner,
            $getLoser
        ]);

        $user->syncPermissions([
            $login,
            $logout,
            $showPlayerGames,
            $updateName,
            $destroyPlayerThrows,
            $throwDice
        ]);

        
    }
}
