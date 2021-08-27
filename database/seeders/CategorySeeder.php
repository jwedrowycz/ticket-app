<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            [
                [
                    'value' => 0,
                    'name' => 'incidents'
                ],
                [
                    'value' => 1,
                    'name' => 'orders'
                ],
                [
                    'value' => 2,
                    'name' => 'questions'
                ],
            ]
        );
    }
}
