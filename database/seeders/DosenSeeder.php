<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Dosen::insert([
            [
                'nidn' => '2025',
                'nip' => '19911919919191919',
                'nama' => 'Dosen 1',
                'email' => 'mhs@gmail.com',
                'id_prodi' => '1',
                'tempat_lahir' => 'Bengkulu',
                'tanggal_lahir' => '2025-05-04',
                'no_hp' => '012235662781',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nidn' => '2026',
                'nip' => '19911919919191918',
                'nama' => 'Dosen Koordinator Permohonan Pengambilan Data Penelitian',
                'email' => 'koordinatorppdp@gmail.com',
                'id_prodi' => '1',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2025-05-04',
                'no_hp' => '012235662781',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nidn' => '2027',
                'nip' => '19911919919191921',
                'nama' => 'Seseorang S. Pd.',
                'email' => 'seseorang@gmail.com',
                'id_prodi' => '1',
                'tempat_lahir' => 'Ngawi',
                'tanggal_lahir' => '2025-05-21',
                'no_hp' => '012235662781',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nidn' => '2028',
                'nip' => '199119199982911',
                'nama' => 'Manusia S. Kom., M. Kom.',
                'email' => 'manusia@gmail.com',
                'id_prodi' => '1',
                'tempat_lahir' => 'Sumenep',
                'tanggal_lahir' => '2025-06-21',
                'no_hp' => '012235662781',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
