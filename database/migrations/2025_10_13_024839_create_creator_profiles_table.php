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
        Schema::create('creator_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->json('specialties')->nullable(); // ["birthdays", "anniversaries", "holiday"]
            $table->string('portfolio_url')->nullable();
            $table->integer('experience_years')->default(0);
            $table->enum('pricing_tier', ['free', 'basic', 'premium', 'enterprise'])->default('free');
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_greetings_created')->default(0);
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->json('verification_documents')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('availability_status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_profiles');
    }
};
