<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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

        User::factory(20)->create();
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@ticket-app.pl',
                'password' => Hash::make('qweqweqwe'),
                'created_at' => Carbon::now(),
            ],               
        ]);
    }
}
