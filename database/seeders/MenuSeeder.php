<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Hak Akses
         \App\Models\Menu::insert([
            [
                'header' => 'Dashboard',
                'menu' => 'Dashboard',
                'url' => 'dashboard',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Surat',
                'menu' => 'Surat Persetujuan Sidang Skripsi',
                'url' => 'sidang-skripsi',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Surat',
                'menu' => 'Surat Permohonan Sidang Skripsi',
                'url' => 'surat-permohonan-sidang-skripsi',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Profil',
                'menu' => 'Lihat Profil',
                'url' => 'lihat-profil',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Surat',
                'menu' => 'Surat Permohonan Seminar Proposal',
                'url' => 'surat-keterangan-lulus',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Data Master',
                'menu' => 'Data Mahasiswa',
                'url' => 'data-master',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Data Master',
                'menu' => 'Data Dosen',
                'url' => 'data-master',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Admin',
                'menu' => 'Hak Akses',
                'url' => 'hak-akses',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}