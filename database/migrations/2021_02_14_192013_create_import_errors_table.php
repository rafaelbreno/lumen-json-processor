<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('log_file_id');

            /* Serialized Error
             * */
            $table->text('error');

            /*
             * 0 - Parsing Error
             * 1 - Validation Error
             * 2 - File not found
             * */
            $table->tinyInteger('type');
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
        Schema::dropIfExists('import_errors');
    }
}
