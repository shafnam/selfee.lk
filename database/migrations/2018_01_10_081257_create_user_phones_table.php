<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_phones')){
            Schema::create('user_phones', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('customer_id')->unsigned();
                $table->string('mobile_number');
                $table->timestamps();
            });
        }

        Schema::table('user_phones', function($table) {
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_phones');
    }
}
