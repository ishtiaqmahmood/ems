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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();

            // Organization Link
            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnDelete();


            // Department Link
            $table->foreignId('department_id')
                ->constrained('departments')
                ->cascadeOnDelete();


            // UUID
            $table->uuid('uuid')->unique()->nullable();

            // Basic Info
            $table->string('name')->index();
            $table->string('slug')->unique()->nullable();
            $table->string('code')->unique()->nullable();

            // Multiple Images (JSON Array)
            $table->json('images')->nullable();

            // Description + Metadata
            $table->longText('description')->nullable();

            // Status + Sorting Order
            $table->enum('status', ['active', 'inactive', 'archived'])
                ->default('active')
                ->index();

            $table->integer('sort_order')->default(0)->index();

            //  Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            // Date Fields
            $table->timestamps();

            //  Full-text search support for fast search
             // $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
