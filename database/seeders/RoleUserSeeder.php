<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::find(1)?->roles()->sync([1]);
        User::find(2)?->roles()->sync([2, 5, 6, 7]);
        User::find(3)?->roles()->sync([3]);
        User::find(5)?->roles()->sync([8]);
    }
}
