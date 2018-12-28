<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRejectedAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('rejected_ads')){
            Schema::create('rejected_ads', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ad_id')->unsigned();
                $table->string('reason');
                $table->timestamps();
            });
        }

        Schema::table('rejected_ads', function($table) {
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
        Schema::dropIfExists('rejected_ads');
    }
}
