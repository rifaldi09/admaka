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
        ]);
    }
}