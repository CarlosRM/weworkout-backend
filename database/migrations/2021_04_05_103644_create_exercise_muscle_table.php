<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExerciseMuscleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_muscle', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('exercise_id');
            $table->foreign('exercise_id')
                    ->references('id')
                    ->on('exercises')->onDelete('cascade');

            $table->unsignedBigInteger('muscle_id');
            $table->foreign('muscle_id')
                    ->references('id')
                    ->on('muscles')->onDelete('cascade');
        
            $table->unique(['exercise_id', 'muscle_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_muscle');
    }
}
