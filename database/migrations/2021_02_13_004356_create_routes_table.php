<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        "route":{
          "id":"0636a119-b7ee-3828-ae83-5f7ebbb99831",
          "hosts":"miller.com",
          "methods":[
            "GET",
            "POST",
            "PUT",
            "DELETE",
            "PATCH",
            "OPTIONS",
            "HEAD"
          ],
          "paths":[
            "\/"
          ],
          "preserve_host":false,
          "protocols":[
            "http",
            "https"
          ],
          "regex_priority":0,
          "service":{
            "id":"c3e86413-648a-3552-90c3-b13491ee07d6"
          },
          "strip_path":true,
          "created_at":1564823899,
          "updated_at":1564823899
        },
         * */
        Schema::create('routes', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('hosts');
            $table->text('methods');
            $table->text('paths');
            $table->boolean('preserve_host');
            $table->text('protocols');
            $table->integer('regex_priority');
            $table->uuid('service_id');
            $table->boolean('strip_path');
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
        Schema::dropIfExists('routes');
    }
}
