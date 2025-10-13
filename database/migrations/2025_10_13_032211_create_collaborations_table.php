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
        Schema::create('collaborations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('greeting_id')->constrained()->onDelete('cascade');
            $table->foreignId('collaborator_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['editor', 'contributor', 'viewer']);
            $table->enum('status', ['invited', 'accepted', 'declined']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborations');
    }
};
