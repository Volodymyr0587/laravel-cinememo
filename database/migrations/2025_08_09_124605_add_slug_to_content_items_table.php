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
        Schema::table('content_items', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        // Заповнюємо slug для існуючих записів
        $items = \App\Models\ContentItem::all();
        foreach ($items as $item) {
            $item->slug = \Illuminate\Support\Str::slug($item->title);
            $item->save();
        }

        Schema::table('content_items', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
