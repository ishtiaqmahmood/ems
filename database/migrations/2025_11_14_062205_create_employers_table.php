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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            // Organization
            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnDelete();


            // Department
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();


            // Section
            $table->foreignId('section_id')
                ->nullable()
                ->constrained('sections')
                ->nullOnDelete();


            // UUID
            $table->uuid('uuid')->unique()->nullable();

            // Basic Info
            $table->string('name')->index();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();

            // Personal Info
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group')->nullable();

            // Address
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address')->nullable();

            // Profile Image + Docs
            $table->string('profile_image')->nullable();
            $table->json('documents')->nullable(); // ["cv.pdf", "nid.jpg"]

            // Employment Info
            $table->date('joining_date')->nullable();
            $table->date('resign_date')->nullable();


            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_relation')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'terminated', 'resigned'])
                ->default('active')
                ->index();

            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Full text search for large HRM databases
             // $table->fullText(['name', 'email', 'phone', 'designation']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
