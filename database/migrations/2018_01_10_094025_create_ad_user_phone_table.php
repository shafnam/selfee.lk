<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdPhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('ad_user_phone')){
            Schema::create('ad_user_phone', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_phone_id')->unsigned()->nullable();
                $table->integer('ad_id')->unsigned()->nullable();
                $table->timestamps();
            });
        }

        Schema::table('ad_user_phone', function($table) {
            $table->foreign('user_phone_id')->references('id')->on('user_phones');
            $table->foreign('ad_id')->references('id')->on('ads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_phone');
    }
}
