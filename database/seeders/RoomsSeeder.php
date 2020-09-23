<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 3; $i++) { 
            for ($j=0; $j < 5; $j++) { 
                DB::table('rooms')->insert([
                    'type_id' => $i,
                ]);
            }
        }
           
    }
}
