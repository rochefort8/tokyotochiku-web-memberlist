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
            $table->string('removed')->nullable();
            $table->string('former_name_kanji')->nullable();
            $table->string('last_name_kanji')->nullable();
            $table->string('first_name_kanji')->nullable();
            $table->string('former_name_kana')->nullable();
            $table->string('last_name_kana')->nullable();
            $table->string('first_name_kana')->nullable();
            $table->string('gender')->nullable();                   
            $table->string('zipcode')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
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
            $table->string('newsletter_undelivered')->nullable();
            $table->string('party_attendance')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
