<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthBeautyAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('health_beauty_ads')){
            Schema::create('health_beauty_ads', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ad_id')->unsigned();
                $table->string('condition');
                $table->string('type');
                $table->string('gender');
                $table->string('authenticity');
                $table->string('size');
                $table->timestamps();
            });
        }

        Schema::table('health_beauty_ads', function($table) {
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
        Schema::dropIfExists('health_beauty_ads');
    }
}
