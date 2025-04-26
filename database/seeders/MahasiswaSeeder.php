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
        // seeder database untuk isi table mahasiswa di database
        \App\Models\Mahasiswa::create([
            'username' => 'Testing User',
            'password' => Hash::make(123),
        ]);
    }
}
