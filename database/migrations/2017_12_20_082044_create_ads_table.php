<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('ads')){
            Schema::create('ads', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->integer('category_id')->unsigned();
                $table->integer('location_id')->unsigned();
                $table->mediumText('description');
                $table->decimal('price', 10, 2);
                $table->integer('type_id')->unsigned();
                $table->boolean('negotiable'); //0=fixed, 1=negotiable
                $table->integer('customer_id')->unsigned();
                $table->string('slug');
                $table->tinyInteger('status');
                $table->timestamps();
            });
        }

        Schema::table('ads', function($table) {
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('type_id')->references('id')->on('ad_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
