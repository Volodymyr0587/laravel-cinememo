<?php

use App\Models\User;
use App\Models\ContentType;
use App\Enums\ContentStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ContentType::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('original_title')->nullable(); // for example, Japanese or some other languages
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_id', 20)->nullable();
            $table->integer('duration_in_seconds')->nullable();
            $table->date('release_date')->nullable();
            $table->unsignedInteger('number_of_seasons')->nullable();
            $table->unsignedInteger('season_number')->nullable();
            $table->unsignedInteger('number_of_series_of_season')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->string('language')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ContentStatus::values())->default(ContentStatus::WillWatch->value);
            $table->boolean('is_public')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_items');
    }
};
