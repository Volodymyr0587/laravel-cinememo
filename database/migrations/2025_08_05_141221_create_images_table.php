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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
             // Add polymorphic columns
            $table->morphs('imageable'); // This will create an imageable_id and imageable_type
            // Add enum for image type (main or additional)
            $table->enum('type', ['main', 'additional'])->default('additional');
            // Add index for best productivity
            $table->index(['imageable_type', 'imageable_id', 'type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
