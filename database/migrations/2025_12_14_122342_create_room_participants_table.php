<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_participants', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // If user is deleted, remove them from room

            $table->foreignId('room_id')
                ->constrained('rooms')
                ->onDelete('cascade'); // If room is deleted, remove all participants

            // Optional: Role management (e.g., 'member', 'admin')
            $table->string('role')->default('member');

            // Optional: Banning mechanism
            $table->boolean('is_banned')->default(false);

            // Standard timestamps (created_at = joined_at)
            $table->timestamps();

            // Unique Constraint: A user can't join the same room twice
            $table->unique(['user_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_participants');
    }
};
