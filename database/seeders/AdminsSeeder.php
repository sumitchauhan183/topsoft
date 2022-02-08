<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'status' => 'active',
            'role' => 'admin',
            'profile_image' => 'https://cdn4.vectorstock.com/i/1000x1000/47/93/person-icon-iconic-design-vector-18314793.jpg',
            'password' => Hash::make('password'),
        ]);
    }
}
