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
        Schema::create('content_item_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('person_id')->constrained()->cascadeOnDelete();
            $table->foreignId('profession_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // Додаємо унікальний індекс, щоб уникнути дублікатів
            // Наприклад, одна й та сама людина не може бути двічі режисером в одному фільмі.
            $table->unique(['content_item_id', 'person_id', 'profession_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_item_person');
    }
};
