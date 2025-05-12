<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{

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
            //! Menu surat menggunakan {role} yang dimana untuk membedakan role
            //! yang ada di dalam menu, misal {role} = mahasiswa, maka urlnya menjadi mahasiswa/aktif-kuliah
            [
                'header' => 'Surat',
                'menu' => 'Surat Aktif Kuliah',
                'url' => '{role}/aktif-kuliah',
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
                'url' => 'data-mahasiswa',
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
            //! Menu surat menggunakan {role} yang dimana untuk membedakan role
            //! yang ada di dalam menu, misal {role} = mahasiswa, maka urlnya menjadi mahasiswa/pengajuan-kp
            [
                'header' => 'Surat',
                'menu' => 'Surat Pengajuan Kerja Praktik',
                'url' => '{role}/pengajuan-kp',
                'icon' => 'fa-solid fa-circle fa-2xs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
