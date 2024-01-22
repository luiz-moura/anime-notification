<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('approved');
            $table->boolean('airing');
            $table->string('type')->nullable();
            $table->string('source')->nullable();
            $table->integer('episodes')->nullable();
            $table->string('status')->nullable();
            $table->string('duration')->nullable();
            $table->string('rating')->nullable();
            $table->text('synopsis')->nullable();
            $table->text('background')->nullable();
            $table->string('season')->nullable();
            $table->integer('year')->nullable();
            $table->dateTime('aired_from')->nullable();
            $table->dateTime('aired_to')->nullable();
            $table->bigInteger('mal_id')->unique();
            $table->string('mal_url')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
