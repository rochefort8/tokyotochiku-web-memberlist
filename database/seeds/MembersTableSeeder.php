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
            $member->removed            = $line[2] ;
            $member->former_name_kanji  = $line[3] ;
            $member->last_name_kanji    = $line[4] ;
            $member->first_name_kanji   = $line[5] ;
            $member->former_name_kana   = $line[6] ;
            $member->last_name_kana     = $line[7] ;
            $member->first_name_kana    = $line[8] ;
            $member->gender             = $line[9] ;        
            $member->zipcode            = $line[10] ;
            $member->address1           = $line[11] ;
            $member->address2           = $line[12] ;
            $member->address3           = $line[13] ;
            $member->phone1             = $line[14] ;
            $member->phone2             = $line[15] ;
            $member->email              = $line[16] ;
            $member->club               = $line[17] ;
            $member->junior_high_school = $line[18] ;
            $member->couple             = $line[19] ;                
            $member->representative     = $line[20] ;
            $member->bereau             = $line[21] ;
            $member->remarks            = $line[22] ;
            $member->annual_fee         = $line[23] ;
            $member->party_attendance   = $line[24] ;
            $member->save();
        }       
    }
}
