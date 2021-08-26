<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert(
            [
                [
                    'state' => 0,
                    'color' => 'bg-info'
                ], // niski
                [
                    'state' => 1,
                    'color' => 'bg-warning'
                ], // średni
                [
                    'state' => 2,
                    'color' => 'bg-l-red'
                ], // wysoki
            ]
        );
    }
}
