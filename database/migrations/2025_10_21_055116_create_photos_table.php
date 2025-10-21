<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();

            // Photo information
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path');

            // Relationships
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Categorization
            $table->string('category')->nullable();
            $table->string('tags')->nullable();

            // Visibility setting (enum)
            $table->enum('visibility', ['private', 'public'])->default('public');

            // Extra metadata
            $table->unsignedBigInteger('views')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};