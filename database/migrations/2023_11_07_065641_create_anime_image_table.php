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
        Schema::create('anime_image', function (Blueprint $table) {
            $table->foreignId('anime_id')
                ->constrained('animes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('image_id')
                ->constrained('images')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['anime_id', 'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_image');
    }
};
