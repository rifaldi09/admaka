<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Hak Akses
            \App\Models\Prodi::insert([
                [
                    'nama' => 'Teknik Informatika',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama' => 'Teknik Elektro',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama' => 'Teknik Perkapalan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama' => 'Teknik Industri',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama' => 'Kimia',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama' => 'Perancangan Wilayah Kota',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama' => 'Teknik Sipil',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama' => 'Sistem Informasi',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                
                ]);
    }
}