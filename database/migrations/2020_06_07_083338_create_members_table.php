<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->string('graduate')->nullable();
            $table->string('id')->nullable();
            $table->string('former_name_kanji')->nullable();
            $table->string('last_name_kanji')->nullable();
            $table->string('first_name_kanji')->nullable();
            $table->string('former_name_kana')->nullable();
            $table->string('last_name_kana')->nullable();
            $table->string('first_name_kana')->nullable();
            $table->string('gender')->nullable();                   
            $table->string('postcode')->nullable();
            $table->string('address')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('club')->nullable();
            $table->string('junior_high_school')->nullable();
            $table->string('couple')->nullable();                           
            $table->string('representative')->nullable();
            $table->string('bereau')->nullable();
            $table->string('remarks')->nullable();
            $table->string('annual_fee')->nullable();
            $table->string('party_attendance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
