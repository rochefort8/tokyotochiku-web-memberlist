<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'graduate',
        'removed',
        'former_name_kanji',
        'last_name_kanji',
        'first_name_kanji' ,
        'former_name_kana' ,
        'last_name_kana' ,
        'first_name_kana'  ,
        'gender',
        'zipcode'  ,   
        'address1'   ,
        'address2'   ,
        'address3'   ,
        'phone1',
        'phone2',
        'email' ,
        'club'  ,
        'junior_high_school',
        'couple',
        'representative',
        'bereau',
        'remarks'   ,
        'annual_fee',
        'party_attendance',  
    ];
}
