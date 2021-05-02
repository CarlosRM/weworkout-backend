<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimilarRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similar_routines', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('routine');
            $table->foreign('routine')
                    ->references('id')
                    ->on('routines')->onDelete('cascade');
            $table->unsignedBigInteger('similar');
            $table->foreign('similar')
                    ->references('id')
                    ->on('routines')->onDelete('cascade');

            $table->unique(['routine', 'similar']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('similar_routines');
    }
}
