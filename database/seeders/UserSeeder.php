<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'SEBASTIAN LIMAS',
            'email' => 'slimas@gmail.com',
            'password' => Hash::make('@Slimas123#'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'HANS SÁNCHEZ',
            'email' => 'hsanchez@gmail.com',
            'password' => Hash::make('@Hsanchez123#'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'PEPITO PEREZ',
            'email' => 'pperez@gmail.com',
            'password' => Hash::make('@Pperez123#'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
