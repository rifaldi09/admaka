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
                'nama' => 'Dosen 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
