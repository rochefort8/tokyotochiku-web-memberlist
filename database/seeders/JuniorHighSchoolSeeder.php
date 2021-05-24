<?php

use Illuminate\Database\Seeder;
use App\Models\JuniorHighSchool;

class JuniorHighSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = fopen("database/seeds/jhs_base.csv", "r");
        while($line = fgetcsv($f)){
            $jhs = new JuniorHighSchool;
            $jhs->name       = $line[0] ;
            $jhs->save();
        }       
    }
}
