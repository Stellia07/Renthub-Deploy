<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Admin

            [
                'name' => 'Admin', 
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',
            ],

            // Owner

            [
                'name' => 'Owner',
                'username' => 'owner',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'owner',
                'status' => 'active',
            ],

            // Tenant

            [
                'name' => 'Tenant', 
                'username' => 'tenant',
                'email' => 'tenant@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'tenant',
                'status' => 'active',
            ],

            // User

            [
                'name' => 'User', 
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'user',
                'status' => 'active',
            ],
        ]);
    }
}
