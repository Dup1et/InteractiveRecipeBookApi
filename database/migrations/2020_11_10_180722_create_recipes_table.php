<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 64);
            $table->string('description', 500);
            $table->string('preview', 255)->nullable();
            $table->time('cooking_time');
            $table->unsignedTinyInteger('portions')->default(1);
            $table->unsignedBigInteger('language_id');
            $table->json('body');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('language_id')->on('languages')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
