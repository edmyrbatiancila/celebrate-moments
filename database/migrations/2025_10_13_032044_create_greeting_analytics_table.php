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
        Schema::create('greeting_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('greeting_id')->constrained()->onDelete('cascade');
            $table->integer('views_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->json('engagement_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greeting_analytics');
    }
};
