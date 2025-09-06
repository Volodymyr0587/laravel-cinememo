<?php

use App\Models\Actor;
use App\Models\ContentItem;
use App\Models\User;
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
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('biography')->nullable();
            $table->string('birth_date', 10)->nullable();
            $table->string('death_date', 10)->nullable();
            $table->string('birth_place')->nullable();
            $table->string('death_place')->nullable();
            $table->timestamps();
        });

        Schema::create('actor_content_item', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Actor::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ContentItem::class)->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['actor_id', 'content_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_content_item');
        Schema::dropIfExists('actors');
    }
};
