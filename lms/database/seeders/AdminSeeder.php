<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; //Import your Admin model

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
