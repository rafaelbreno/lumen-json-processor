<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headers', function (Blueprint $table) {
            $table->uuid('id');

            /**
             *  "Content-Length": "197",
             *  "via": "gateway/0.3.0",
             *  "Connection": "close",
             *  "access-control-allow-credentials": "true",
             *  "Content-Type": "application/json",
             *  "server": "nginx",
             *  "access-control-allow-origin": "*"
             *  "accept": "*\/*",
             *  "host": "httpbin.org",
             *  "user-agent": "curl/7.37.1"
             * */
            $table->unsignedInteger('content_length')->nullable();
            $table->string('via')->nullable();
            $table->string('connection')->nullable();
            $table->boolean('access_control_allow_credentials')->nullable();
            $table->string('access_control_allow_origin')->nullable();
            $table->string('content_type')->nullable();
            $table->string('server')->nullable();
            $table->string('accept')->nullable();
            $table->string('host')->nullable();
            $table->string('user_agent')->nullable();
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
        Schema::dropIfExists('headers');
    }
}
