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
        Schema::create('meal_tag', function (Blueprint $table) {
            $table->timestamps();

            $table->integer('tag_id')->unsigned();
            $table->integer('meal_id')->unsigned();
            
            $table->unique(['tag_id', 'meal_id']);
            // $table->foreign('meal_id')->references('id')->on('meals')
            // ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_tag');
    }
};