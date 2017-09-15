<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('teams', function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('team_name');
              $table->integer('noofmembers');
            $table->string('password');
            $table->rememberToken();
              $table->string('team_id');
              $table->boolean('shortlisted')->default(0);
            $table->integer('topic_id')->unsigned();
            $table->integer('domain_id')->unsigned();
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
        Schema::dropIfExists('teams');
    }
}
