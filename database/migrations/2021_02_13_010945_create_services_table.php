<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        "service":{
          "id":"c3e86413-648a-3552-90c3-b13491ee07d6",
          "connect_timeout":60000,
          "host":"ritchie.com",
          "name":"ritchie",
          "path":"\/",
          "port":80,
          "protocol":"http",
          "read_timeout":60000,
          "retries":5,
          "write_timeout":60000
          "updated_at":1563589483,
          "created_at":1563589483,
        },
         * */
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedInteger('connect_timeout');
            $table->string('host');
            $table->string('name');
            $table->string('path');
            $table->unsignedSmallInteger('port');
            $table->string('protocol');
            $table->unsignedInteger('read_timeout');
            $table->unsignedSmallInteger('retries');
            $table->unsignedInteger('write_timeout');
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
        Schema::dropIfExists('services');
    }
}
