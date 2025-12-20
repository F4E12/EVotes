<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_id')->unique();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');

            $table->string('name');
            $table->string('photo_url')->nullable();
            $table->text('vision');
            $table->text('mission');


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
