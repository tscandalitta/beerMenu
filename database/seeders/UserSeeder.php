<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);
        $admin->assignRole('admin');

        $waiter = User::create([
            'name' => 'waiter',
            'email' => 'waiter@waiter.com',
            'password' => Hash::make('waiter'),
        ]);
        $waiter->assignRole('waiter');

        $manager = User::create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => Hash::make('manager'),
        ]);
        $waiter->assignRole('manager');
    }
}
