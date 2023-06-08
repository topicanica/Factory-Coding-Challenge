<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredient_meal', function (Blueprint $table) {
            $table->timestamps();

            $table->integer('ingredient_id')->unsigned();
            $table->integer('meal_id')->unsigned();
            
            $table->unique(['ingredient_id', 'meal_id']);
            $table->foreign('meal_id')->references('id')->on('meals');
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_meal');
    }
};
