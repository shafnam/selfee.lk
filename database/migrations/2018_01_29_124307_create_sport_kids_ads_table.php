<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportKidsAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sport_kids_ads')){
            Schema::create('sport_kids_ads', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ad_id')->unsigned();
                $table->string('condition');
                $table->string('type');
                $table->string('gender');                
                $table->timestamps();
            });
        }

        Schema::table('sport_kids_ads', function($table) {
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
        Schema::dropIfExists('sport_kids_ads');
    }
}
