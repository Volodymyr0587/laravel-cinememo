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
        Schema::table('content_types', function (Blueprint $table) {
            $table->dropUnique(['name']); // remove global unique
            $table->unique(['user_id', 'name']); // add scoped unique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_types', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'name']); // remove scoped unique
            $table->unique('name'); // restore global unique
        });
    }
};
