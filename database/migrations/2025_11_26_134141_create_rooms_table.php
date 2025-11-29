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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_id')->unique();

            // hostID: Foreign Key to User
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');

            $table->string('title');
            $table->text('description');

            // uniqueToken: Should be unique
            $table->string('unique_token')->unique();

            // isRevealed: Boolean to indicate if results are revealed
            $table->boolean('is_revealed')->default(false);

            // Date fields
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
