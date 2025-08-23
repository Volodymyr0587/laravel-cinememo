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
        Schema::table('images', function (Blueprint $table) {
             // Remove old columns
            $table->dropForeign(['content_item_id']);
            $table->dropColumn('content_item_id');

            // Add polymorphic columns
            $table->morphs('imageable'); // Це створить imageable_id та imageable_type

            // Add enum for image type (main or additional)
            $table->enum('type', ['main', 'additional'])->default('additional');

            // Add index for best productivity
            $table->index(['imageable_type', 'imageable_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropMorphs('imageable');
            $table->dropColumn('type');
            $table->foreignIdFor(\App\Models\ContentItem::class)->constrained()->cascadeOnDelete();
        });
    }
};
