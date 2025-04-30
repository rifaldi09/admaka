<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'id_user' => '127',
                'password' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'id_user' => '2025',
                'password' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        \App\Models\Dosen::insert([
            [
                'nidn' => '2025',
                'nama' => 'Dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Mahasiswa
        \App\Models\Mahasiswa::insert([
            [
                'nim' => '133',
                'nama' => 'Mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '127',
                'nama' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Hak Akses
        \App\Models\HakAkses::insert([
            [
                'header' => 'Surat',
                'menu' => 'Surat Persetujuan Sidang Skripsi',
                'url' => 'sidang-skripsi',
                'icon' => 'fa-solid fa-file-pen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Surat',
                'menu' => 'Surat Permohonan Sidang Skripsi',
                'url' => 'surat-permohonan-sidang-skripsi',
                'icon' => 'fa-solid fa-file-pen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Profil',
                'menu' => 'Lihat Profil',
                'url' => 'lihat-profil',
                'icon' => 'fa-solid fa-file-pen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Surat',
                'menu' => 'Surat Permohonan Seminar Proposal',
                'url' => 'surat-keterangan-lulus',
                'icon' => 'fa-solid fa-file-pen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'header' => 'Admin',
                'menu' => 'Data Master',
                'url' => 'data-master',
                'icon' => 'fa-solid fa-file-pen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Role Akses
        \App\Models\RoleAkses::insert([
            ['id_user' => 1, 'id_akses' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 1, 'id_akses' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 1, 'id_akses' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 1, 'id_akses' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_user' => 2, 'id_akses' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
