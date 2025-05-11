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
                'menu' => 'Surat Aktif Kulaih',
                'url' => 'aktif-kuliah',
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
                'header' => 'Data Master',
                'menu' => 'Data Mahasiswa',
                'url' => 'data-mhs',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Data Master',
                'menu' => 'Data Dosen',
                'url' => 'data-dosen',
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
            ],
            [
                'header' => 'Surat',
                'menu' => 'Surat Pengajuan Kerja Praktik',
                'url' => 'pengajuan-kp',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Surat',
                'menu' => 'Surat Pengajuan Kerja Praktik',
                'url' => 'pengajuan-kp-admin',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Surat',
                'menu' => 'Surat Pengajuan Kerja Praktik',
                'url' => 'pengajuan-kp-koordinator',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}