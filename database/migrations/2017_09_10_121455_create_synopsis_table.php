<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSynopsisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('synopsis', function (Blueprint $table) {
            $table->increments('id')->unsigned();
           $table->string('synopsis');
            $table->integer('team_id')->unsigned();
            $table->integer('domain_id')->unsigned();
            $table->integer('topic_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('domain_id')->references('id')->on('domains');
            $table->foreign('topic_id')->references('id')->on('topics');

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
        Schema::dropIfExists("synopsis");
    }
}
