<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $waiterRole = Role::create(['name' => 'waiter']);
        $managerRole = Role::create(['name' => 'manager']);
        $adminRole = Role::create(['name' => 'admin']);

        $createOrders = Permission::create(['name' => 'create orders']);
        $retrieveOrders = Permission::create(['name' => 'retrieve orders']);
        $updateOrders = Permission::create(['name' => 'update orders']);
        Permission::create(['name' => 'delete orders']);

        $createItems = Permission::create(['name' => 'create items']);
        $retrieveItems = Permission::create(['name' => 'retrieve items']);
        $updateItems = Permission::create(['name' => 'update items']);
        Permission::create(['name' => 'delete items']);

        $createTables = Permission::create(['name' => 'create tables']);
        $retrieveTables = Permission::create(['name' => 'retrieve tables']);
        $updateTables = Permission::create(['name' => 'update tables']);
        Permission::create(['name' => 'delete tables']);

        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'retrieve users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'read charts']);

        $adminRole->syncPermissions(Permission::all());

        $managerRole->syncPermissions([
            $createOrders,
            $retrieveOrders,
            $updateOrders,
            $createItems,
            $retrieveItems,
            $updateItems,
            $createTables,
            $retrieveTables,
            $updateTables
        ]);

        $waiterRole->syncPermissions([
            $retrieveOrders,
            $retrieveTables,
            $updateTables
        ]);
    }
}
