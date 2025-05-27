<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Users
        \App\Models\User::insert([
            [
                'id' => 1,
                'id_user' => '133',
                'password' => Hash::make('123'),
                'id_role' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'id_user' => '2025',
                'password' => Hash::make('123'),
                'id_role' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'id_user' => '1234',
                'password' => Hash::make('123'),
                'id_role' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'id_user' => '1334',
                'password' => Hash::make('123'),
                'id_role' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'id_user' => '2026',
                'password' => Hash::make('123'),
                'id_role' => '6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'id_user' => '2027',
                'password' => Hash::make('123'),
                'id_role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'id_user' => '2028',
                'password' => Hash::make('123'),
                'id_role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}