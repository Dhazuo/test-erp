<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            [
                'name' => 'Prueba Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin@admin.com'),
                'role' => 'admin'
            ],
            [
                'name' => 'Prueba Manager',
                'email' => 'manager@manager.com',
                'password' => Hash::make('manager@manager.com'),
                'role' => 'manager'
            ],
            [
                'name' => 'Prueba Vendedor',
                'email' => 'seller@seller.com',
                'password' => Hash::make('seller@seller.com'),
                'role' => 'seller'
            ]
        ];

        foreach ($list as $user) {
            DB::table('users')->insert([
               'name' => $user['name'],
               'email' => $user['email'],
               'password' => $user['password'],
               'role' => $user['role']
            ]);
        }
    }
}
