<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            [
                'name' => 'Admin',
                'email' => 'admin@ticket-app.pl',
                'password' => Hash::make('qweqweqwe'),
            ],               
            [
                'name' => 'Jakub Kopniewski',
                'email' => 'jakub@test.com',
                'password' => Hash::make('qweqweqwe'),
            ],   
            [
                'name' => 'Adam Nowak',
                'email' => 'adam@test.com',
                'password' => Hash::make('qweqweqwe'),
            ],               
        ]);
    }
}
