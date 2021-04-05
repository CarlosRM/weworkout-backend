<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetsWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets_workouts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('set_id');
            $table->foreign('set_id')
                    ->references('id')
                    ->on('sets')->onDelete('cascade');

            $table->unsignedBigInteger('workout_id');
            $table->foreign('workout_id')
                    ->references('id')
                    ->on('workouts')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sets_workouts');
    }
}
