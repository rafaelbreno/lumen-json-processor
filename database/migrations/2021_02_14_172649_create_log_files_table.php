<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_files', function (Blueprint $table) {
            $table->id();

            /* Filename
             * storage_path/year/month/uui4.{extension}
             * */
            $table->string('filename')->unique();

            /* Status
             * -1 Found Errors
             * 0 - Not Processed
             * 1 - Processing
             * 2 - Finished Processing
             * */
            $table->tinyInteger('status');
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
        Schema::dropIfExists('log_files');
    }
}
