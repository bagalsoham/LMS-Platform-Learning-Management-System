<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Soham Bagal',
                'email' => 'soham@gmail.com',
                'password' => bcrypt('sohambagal'),
                'role' => 'student',
            ],
            [
                'name' => 'Instructor',
                'email' => 'instructor@gmail.com',
                'password' => bcrypt('instructor'),
                'role' => 'instructor',
            ]
        ];
        
        User::insert($users);
    }
}
