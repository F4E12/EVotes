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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('voter_id')->constrained('users')->onDelete('cascade');

            // votedAt: The explicit timestamp from the schema
            $table->timestamp('voted_at');

            // Unique Constraint: Ensure a user can only vote once per room.
            $table->unique(['room_id', 'voter_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
