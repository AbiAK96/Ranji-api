<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Vinod',
            'last_name' => 'Madushan',
            'email' => 'vinod@konekt.lk',
            'mobile' => '0752938243',
            'password' => Hash::make('Vinod@12'),
            'role' => 'admin',
            'is_worker' => false,
        ]);
    }
}
