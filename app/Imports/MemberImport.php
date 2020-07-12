<?php

namespace App\Imports;


use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;

class MemberImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
 
        $member = new Member([
            'graduate'           => $row[0] ,
            'last_name_kanji'    => $row[1] ,
            'first_name_kanji'   => $row[2] ,
            'last_name_kana'     => $row[3] ,
            'first_name_kana'    => $row[4] ,
            'gender'             => $row[5] ,        
            'zipcode'            => $row[6] ,
            'address1'           => $row[7] ,
            'address2'           => $row[8] ,
            'address3'           => $row[9] ,
            'phone1'             => $row[10] ,
            'phone2'             => $row[11] ,
            'email'              => $row[12] ,
            'club'               => $row[13] ,
            'junior_high_school' => $row[14] ,
        ]);
    
        return $member ;

    }
}
