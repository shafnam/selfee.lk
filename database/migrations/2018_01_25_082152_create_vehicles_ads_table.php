<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('vehicles_ads')){
            Schema::create('vehicles_ads', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ad_id')->unsigned();
                $table->string('condition');
                $table->string('brand');
                $table->string('model');
                $table->string('model_year');
                $table->string('mileage');
                $table->string('type');
                $table->string('transmission');
                $table->string('fuel_type');
                $table->string('engine_capacity');
                $table->timestamps();
            });
        }

        Schema::table('vehicles_ads', function($table) {
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
        Schema::dropIfExists('vehicles_ads');
    }
}
