<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('followee');
            $table->foreign('followee')
                    ->references('id')
                    ->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('follower');
            $table->foreign('follower')
                    ->references('id')
                    ->on('users')->onDelete('cascade');

            $table->unique(['follower', 'followee']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
    }
}
