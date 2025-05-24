<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role Akses
        \App\Models\RoleAkses::insert([
            ['id_role' => 1, 'id_menu' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 1, 'id_menu' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 1, 'id_menu' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 1, 'id_menu' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 1, 'id_menu' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 1, 'id_menu' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 1, 'id_menu' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'id_menu' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 5, 'id_menu' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 6, 'id_menu' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 6, 'id_menu' => 10, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}