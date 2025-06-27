<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('test@123'),
            'role'       => 'admin',
            'contact'    => '0700000000',
            'status'     => 'ACTIVE',
        ]);

        // Employee user
        User::create([
            'first_name' => 'Employee',
            'last_name'  => 'User',
            'email'      => 'employee@example.com',
            'password'   => Hash::make('test@123'),
            'role'       => 'employee',
            'contact'    => '0711111111',
            'status'     => 'ACTIVE',
        ]);

        // Customer user
        User::create([
            'first_name' => 'Customer',
            'last_name'  => 'User',
            'email'      => 'customer@example.com',
            'password'   => Hash::make('test@123'),
            'role'       => 'customer',
            'contact'    => '0722222222',
            'status'     => 'ACTIVE',
        ]);
    }
}