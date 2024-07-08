<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rahmat Hidayat',
            'email' => 'rh63800@gmail.com',
            'password' => Hash::make('123123'),
            'no_hp'=> '089506729007'
        ]);
        User::create([
            'name' => 'Dhia Afifah',
            'email' => 'dhiaafifah@gmail.com',
            'password' => Hash::make('123123'),
            'no_hp'=> '082135268203'
        ]);
    }
}
