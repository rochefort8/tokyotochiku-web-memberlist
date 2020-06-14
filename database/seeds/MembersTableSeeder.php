<?php

use Illuminate\Database\Seeder;
use App\Models\Member;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = fopen("database/seeds/tt_base.csv", "r");
        while($line = fgetcsv($f)){
            $member = new Member;
            $member->graduate           = $line[0] ;
            $member->id                 = $line[1] ;
            $member->former_name_kanji  = $line[2] ;
            $member->last_name_kanji    = $line[3] ;
            $member->first_name_kanji   = $line[4] ;
            $member->former_name_kana   = $line[5] ;
            $member->last_name_kana     = $line[6] ;
            $member->first_name_kana    = $line[7] ;
            $member->gender             = $line[8] ;        
            $member->postcode           = $line[9] ;
            $member->address            = $line[10] ;
            $member->phone1             = $line[11] ;
            $member->phone2             = $line[12] ;
            $member->email              = $line[13] ;
            $member->club               = $line[14] ;
            $member->junior_high_school = $line[15] ;
            $member->couple             = $line[16] ;                
            $member->representative     = $line[17] ;
            $member->bereau             = $line[18] ;
            $member->remarks            = $line[19] ;
            $member->annual_fee         = $line[20] ;
            $member->party_attendance   = $line[21] ;
            $member->save();
        }       
    }
}
