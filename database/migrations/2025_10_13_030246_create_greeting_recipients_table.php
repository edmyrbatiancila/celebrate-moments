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
        Schema::create('greeting_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('greeting_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipient_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->boolean('is_thanked')->default(false);
            $table->text('thank_you_message')->nullable();
            $table->timestamps();

            $table->unique(['greeting_id', 'recipient_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greeting_recipients');
    }
};
