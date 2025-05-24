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
                'name_role' => 'Mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_role' => 'Dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_role' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_role' => 'Ketua Prodi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_role' => 'Koordinator Kerja Praktik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_role' => 'Koordinator Pengambilan Data',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}