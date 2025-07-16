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
                'nip' => '199007162025071001',
                'nidn' => '2025',
                'status_pegawai' => 'PNS',
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
                'nip' => '199007152025071001',
                'nidn' => '2026',
                'status_pegawai' => 'PPPK',
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
                'nip' => '199007142025071001',
                'nidn' => '2027',
                'status_pegawai' => 'Kontrak',
                'nama' => 'Seseorang S. Pd.',
                'email' => 'seseorang@gmail.com',
                'id_prodi' => '1',
                'tempat_lahir' => 'Ngawi',
                'tanggal_lahir' => '2025-05-21',
                'no_hp' => '012235662781',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
