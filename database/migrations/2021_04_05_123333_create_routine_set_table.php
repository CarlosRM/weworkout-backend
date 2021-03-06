<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_set', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('routine_id');
            $table->foreign('routine_id')
                    ->references('id')
                    ->on('routines')->onDelete('cascade');

            $table->unsignedBigInteger('set_id');
            $table->foreign('set_id')
                    ->references('id')
                    ->on('sets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routine_set');
    }
}
