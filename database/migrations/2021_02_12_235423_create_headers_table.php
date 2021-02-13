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
            /*
                  "Content-Length": "197",
                  "via": "gateway/0.3.0",
                  "Connection": "close",
                  "access-control-allow-credentials": "true",
                  "Content-Type": "application/json",
                  "server": "nginx",
                  "accept": "*\/*",
                  "host": "httpbin.org",
                  "user-agent": "curl/7.37.1"
             * */
            $table->unsignedInteger('content_length');
            $table->string('via');
            $table->string('connection');
            $table->boolean('access_control_allow_credentials');
            $table->string('content_type');
            $table->string('server');
            $table->string('accept');
            $table->string('host');
            $table->string('user_agent');
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
