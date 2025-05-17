<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mahasiswa
        \App\Models\Mahasiswa::insert([
            [
                'nim' => '133',
                'nama' => 'Mahasiswa 1',
                'email' => 'mhs@gmail.com',
                'id_prodi' => '1',
                'tempat_lahir' => 'Bengkulu',
                'tanggal_lahir' => '2025-05-04',
                'no_hp' => '012235662781',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        \App\Models\Mahasiswa::insert([
            [
                'nim' => '1334',
                'nama' => 'Mahasiswa 2',
                'email' => 'mhs2@gmail.com',
                'id_prodi' => '1',
                'tempat_lahir' => 'Bengkulu',
                'tanggal_lahir' => '2025-05-04',
                'no_hp' => '012235662782',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}