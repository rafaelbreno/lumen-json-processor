<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLatenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        "latencies":{
          "proxy":1836,
          "gateway":8,
          "request":1058
        },
         * */
        Schema::create('latencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('proxy');
            $table->unsignedInteger('gateway');
            $table->unsignedInteger('request');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('latencies');
    }
}
