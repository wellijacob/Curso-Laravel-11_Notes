<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar multiplos usuários
        DB::table('users')->insert([
            [
                'username' => 'user1@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => now()
            ],
            [
                'username' => 'user2@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => now()
            ],
            [
                'username' => 'user3@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => now()
            ],
            [
                'username' => 'user4@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => now()
            ],
            [
                'username' => 'user5@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => now()
            ],

        ]);
    }
}
