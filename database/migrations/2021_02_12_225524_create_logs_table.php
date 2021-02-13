<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            // request
            $table->foreignId('request_id');
            // upstream_uri
            $table->string('upstream_uri');
            // response
            $table->foreignId('response_id');
            // authenticated_entities
            $table->foreignId('entity_id');
            // route
            $table->foreignUuid('route_id');
            // service
            $table->foreignUuid('service_id');
            // latency
            $table->foreignId('latency_id');
            // client_ip
            $table->ipAddress('client_ip');
            // started_at
            $table->timestamp('started_at');
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
        Schema::dropIfExists('logs');
    }
}
