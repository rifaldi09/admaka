<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // menjalankan semua seeder sekaligus
        // command:
        // php artisan db:seed
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProdiSeeder::class,
            MahasiswaSeeder::class,
            DosenSeeder::class,
            MenuSeeder::class,
            RoleAksesSeeder::class, 
        ]);
    }
}