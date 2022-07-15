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
        $admin = Role::create(['role' => 'admin']);
        $permission1 = Permission::create(['name' => 'api.players.averageSuccessRate']);
        $permission2 = Permission::create(['name' => 'api.players.getRanking']);
        
        
        $admin->syncPermissions([$permission1, $permission2]);

        
    }
}
