<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'edit tasks']);
        Permission::create(['name' => 'delete tasks']);
        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'view tasks']);
        Permission::create(['name' => 'edit cases']);
        Permission::create(['name' => 'delete cases']);
        Permission::create(['name' => 'create cases']);
        Permission::create(['name' => 'view cases']);
        Permission::create(['name' => 'edit firms']);
        Permission::create(['name' => 'delete firms']);
        Permission::create(['name' => 'create firms']);
        Permission::create(['name' => 'view firms']);
        Permission::create(['name' => 'edit clients']);
        Permission::create(['name' => 'delete clients']);
        Permission::create(['name' => 'create clients']);
        Permission::create(['name' => 'view clients']);

        // create roles and assign created permissions

        // this can be done as separate statements
        // $role = Role::create(['name' => 'writer']);
        // $role->givePermissionTo('edit articles');

        // or may be done by chaining
        $role = Role::create(['name' => 'moderator'])
            ->givePermissionTo(['publish articles', 'unpublish articles']);

        $role = Role::create(['name' => 'Super admin']);
        $role->givePermissionTo(Permission::all());
    }
}
