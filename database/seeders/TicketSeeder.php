<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->insert([
            [
                'title' => 'Uszkodzony komputer',
                'descr' => 'Komputer nie chce się włączyć, nie reaguje na przyciski',
                'created_at' => Carbon::now(),
                'user_id' => 2,
                'status_id' => 1,
                'priority_id' => 3,
                'category_id' => 1,
            ],               
            [
                'title' => 'Brak tonera',
                'descr' => 'W drukarce nie ma już tonera, model drukarki: HP 1606',
                'created_at' => Carbon::now(),
                'user_id' => 2,
                'status_id' => 1,
                'priority_id' => 2,
                'category_id' => 2,
            ],   
            [
                'title' => 'Ryza papieru',
                'descr' => 'Potrzebna ryza papieru, pokój 106',
                'created_at' => Carbon::now(),
                'user_id' => 2,
                'status_id' => 1,
                'priority_id' => 1,
                'category_id' => 3,
            ],             
        ]);
    }
}
