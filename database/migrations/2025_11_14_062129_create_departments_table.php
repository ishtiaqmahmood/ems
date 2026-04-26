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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            // Foreign key to Organization
            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnDelete()
                ->index();

            // Optional UUID for enterprise systems
            $table->uuid('uuid')->unique()->nullable();

            // Basic Info
            $table->string('name')->index();
            $table->string('slug')->unique()->nullable();
            $table->string('code')->unique()->nullable();

            // Multiple Images (stored as JSON array)
            $table->json('images')->nullable();

            // Description & Metadata
            $table->longText('description')->nullable();

            // Settings
            $table->enum('status', ['active', 'inactive', 'archived'])
                ->default('active')
                ->index();
            $table->integer('sort_order')->default(0)->index();

            // Audit Trails
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            // Timestamps & Soft Deletes
            $table->timestamps();

            // Full-text Search Index (MySQL Only)
             // $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
