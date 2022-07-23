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

        $allPlayers = Permission::create(['name' => 'api.users.index'])->syncRoles([$admin]);
        $averageSuccessRate = Permission::create(['name' => 'api.players.averageSuccessRate'])->syncRoles([$admin]);
        $showPlayerGames = Permission::create(['name' => 'api.players.showPlayerGames'])->syncRoles([$admin, $user]);
        $updateName = Permission::create(['name' => 'api.players.updateName'])->syncRoles([$admin, $user]);
        $destroyPlayerThrows = Permission::create(['name' => 'api.players.destroyPlayerThrows'])->syncRoles([$admin, $user]);
        $throwDice = Permission::create(['name' => 'api.players.throwDice'])->syncRoles([$admin, $user]);
        $getRanking = Permission::create(['name' => 'api.players.getRanking'])->syncRoles([$admin]);
        $getWinner = Permission::create(['name' => 'api.players.getWinner'])->syncRoles([$admin]);
        $getLoser = Permission::create(['name' => 'api.players.getLoser'])->syncRoles([$admin]);
        
        
        

        
    }
}
