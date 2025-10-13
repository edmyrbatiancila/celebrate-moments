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
        Schema::create('greetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('greeting_type', ['video', 'audio', 'text', 'mixed'])->default('text');
            $table->enum('occasion_type', ['birthday', 'anniversary', 'holiday', 'graduation', 'custom']);
            $table->enum('content_type', ['personal', 'template_based', 'ai_generated']);
            $table->json('content_data'); // stores text, file paths, etc.
            $table->foreignId('template_id')->nullable()->constrained();
            $table->json('theme_settings')->nullable();
            $table->boolean('is_scheduled')->default(false);
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'sent', 'delivered', 'viewed'])->default('draft');
            $table->boolean('is_collaborative')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greetings');
    }
};
