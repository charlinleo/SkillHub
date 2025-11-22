<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password'=> 'admin123',
                'role'=> 'admin',
                'phone'=> '08123456789',
                'address'=> 'Jalan Raya',
            ]
        );
        User::updateOrCreate(
            ['email'=> 'chan@gmail.com'],
            [
                'name'=> 'Charles',
                'password'=> 'char1234',
                'role'=> 'peserta'
                ]
            );
    }
}
