<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('properties_ads')){
            Schema::create('properties_ads', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ad_id')->unsigned();
                $table->string('type');
                $table->string('land_size');
                $table->string('land_unit');
                $table->string('address');
                $table->string('price_unit');
                $table->string('size');
                $table->string('bedrooms');
                $table->string('bathrooms'); 
                $table->timestamps();
            });
        }

        Schema::table('properties_ads', function($table) {
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
        Schema::dropIfExists('properties_ads');
    }
}
