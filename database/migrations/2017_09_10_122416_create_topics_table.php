<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('topic_name');
            $table->integer('domain_id')->unsigned();
            $table->foreign('domain_id')->references('id')->on('domains');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("topics");
    }
}
