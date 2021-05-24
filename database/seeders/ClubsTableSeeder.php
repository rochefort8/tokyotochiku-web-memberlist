<?php

use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = fopen("database/seeds/clubs_base.csv", "r");
        while($line = fgetcsv($f)){
            $club = new Club;
            $club->name               = $line[0] ;
            $club->save();
        }       
    }
}
