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
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
