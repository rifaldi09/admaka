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
                'email' => 'dosen1@umrah.ac.id',
                'prodi_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
