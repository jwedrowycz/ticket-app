<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert(
            [
                ['state' => 0], // wysłany
                ['state' => 1], // w realizacji
                ['state' => 2], // zrealizowany   
            ]
        );
    }
}
