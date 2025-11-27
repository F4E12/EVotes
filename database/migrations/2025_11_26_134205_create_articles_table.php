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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            // authorID: Foreign Key to User
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');

            // relatedRoomID: Foreign Key to Room, is nullable
            $table->foreignId('related_room_id')->nullable()->constrained('rooms')->onDelete('set null');

            $table->string('title');
            $table->longText('content');
            $table->string('thumbnail_url')->nullable();
            
            // publishedAt: Date/Time field, is nullable
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
