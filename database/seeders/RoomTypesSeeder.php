<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['single','double','familiar'];
            for ($i=1; $i <= 3; $i++) { 
                DB::table('room_types')->insert([
                    'name' => $types[$i-1],
                    'beds' => $i,
                ]);
            }

    }
}
