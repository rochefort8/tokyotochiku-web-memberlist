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
        $faker = Faker\Factory::create('ja_JP');
        for ($i = 0; $i < 100; $i++) {
            $member = new Member;
            $member->last_name_kanji    = $faker->name ;
            $member->email   = $faker->email;
            $member->address = $faker->address;
            $member->save();
        }       
    }
}
