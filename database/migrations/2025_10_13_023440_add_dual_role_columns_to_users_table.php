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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_creator')->default(false)->after('email');
            $table->boolean('is_verified_creator')->default(false)->after('is_creator');
            $table->enum('current_role', ['celebrant', 'creator'])->default('celebrant')->after('is_verified_creator');
            $table->string('phone')->nullable()->after('current_role');
            $table->string('avatar')->nullable()->after('phone');
            $table->string('timezone')->default('UTC')->after('avatar');
            $table->date('date_of_birth')->nullable()->after('timezone');
            $table->timestamp('creator_upgraded_at')->nullable()->after('date_of_birth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_creator',
                'is_verified_creator',
                'current_role',
                'phone',
                'avatar',
                'timezone',
                'date_of_birth',
                'creator_upgraded_at'
            ]);
        });
    }
};
