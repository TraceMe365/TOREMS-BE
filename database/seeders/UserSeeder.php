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
            'first_name' => 'Amila',
            'last_name'  => 'Perera',
            'email'      => 'amila@gmail.com',
            'password'   => Hash::make('Abc@1234'),
            'role'       => 'admin',
            'contact'    => '0700000000',
            'status'     => 'ACTIVE',
        ]);

        // Employee user
        User::create([
            'first_name' => 'Gayan',
            'last_name'  => 'Jayawardhana',
            'email'      => 'employee@example.com',
            'password'   => Hash::make('test@1234'),
            'role'       => 'employee',
            'contact'    => '0711111111',
            'status'     => 'ACTIVE',
        ]);

        // Customer user
        User::create([
            'first_name' => 'Jayantha',
            'last_name'  => 'Wijeysinghe',
            'email'      => 'jayantha@example.com',
            'password'   => Hash::make('test@1234'),
            'role'       => 'customer',
            'contact'    => '0722222222',
            'status'     => 'ACTIVE',
        ]);
    }
}