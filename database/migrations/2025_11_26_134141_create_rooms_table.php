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

            // hostID: Foreign Key to User
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');

            $table->string('title');
            $table->text('description');

            // uniqueToken: Should be unique
            $table->string('unique_token')->unique();

            // Date fields
            $table->date('start_date');
            $table->date('end_date');

            // Boolean fields
            $table->boolean('is_revealed')->default(false);
            $table->boolean('is_closed')->default(false);

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
