<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('services_ads')){
            Schema::create('services_ads', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ad_id')->unsigned();
                $table->string('type');
                $table->timestamps();
            });
        }

        Schema::table('services_ads', function($table) {
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
        Schema::dropIfExists('services_ads');
    }
}
