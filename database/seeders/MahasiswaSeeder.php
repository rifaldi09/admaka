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
        // seeder database untuk isi table role di database
        \App\Models\Role::create(
            [
                'role' => 'Mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],);
        \App\Models\Role::create(
            [
                'role' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
        // seeder database untuk isi table hak_akses di database
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
                'menu' => 'Lihat Profi',
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
                'menu' => 'Data Masteer',
                'url' => 'data-master',
                'icon' => 'fa-solid fa-file-pen',
                'created_at' => now(),
                'updated_at' => now(),
            ],]
        );
        // seeder database untuk isi table role_akses di database
        // relasi masih manual karna belum ada halaman yang mengaturnya
        \App\Models\RoleAkses::insert([
            [
                'id_role' => '1',
                'id_akses' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => '1',
                'id_akses' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => '1',
                'id_akses' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => '1',
                'id_akses' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => '2',
                'id_akses' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],]
        );
        // seeder database untuk isi table mahasiswa di database
        // relasi masih manual karna belum ada halaman yang mengaturnya
        \App\Models\Mahasiswa::insert(
            [
                'username' => 'mahasiswa',
                'password' => Hash::make(123),
                'id_role' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],);
        \App\Models\Mahasiswa::insert(
            [
                'username' => 'admin',
                'password' => Hash::make(123),
                'id_role' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }
}
