<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimilarExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similar_exercises', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('exercise');
            $table->foreign('exercise')
                    ->references('id')
                    ->on('exercises')->onDelete('cascade');
            $table->unsignedBigInteger('similar');
            $table->foreign('similar')
                    ->references('id')
                    ->on('exercises')->onDelete('cascade');

            $table->unique(['exercise', 'similar']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('similar_exercises');
    }
}
