<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        Permission::create(['name' => 'create items']);
        Permission::create(['name' => 'read items']);
        Permission::create(['name' => 'update items']);
        Permission::create(['name' => 'delete items']);

        // Create roles and assign permissions
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo([
            'create items',
            'read items',
            'update items',
            'delete items'
        ]);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
