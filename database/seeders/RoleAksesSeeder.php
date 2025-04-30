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
            ['id_user' => 1, 'id_akses' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 1, 'id_akses' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 1, 'id_akses' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 1, 'id_akses' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 3, 'id_akses' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 3, 'id_akses' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
