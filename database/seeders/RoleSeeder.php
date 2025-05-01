<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::insert([
            [
                'id' => '1',
                'name_role' => 'Mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'name_role' => 'Dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '3',
                'name_role' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '4',
                'name_role' => 'Ketua Jurusan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '5',
                'name_role' => 'Ketua Prodi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}