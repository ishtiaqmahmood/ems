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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Basic account info
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Role & employment info
            $table->enum('role', ['Admin', 'HR', 'Viewer'])->default('Viewer');
            $table->string('employee_id')->unique()->nullable()->comment('Unique company employee ID');
            $table->string('designation')->nullable()->comment('Job title or position');
            $table->string('department')->nullable()->comment('Department name');
            $table->date('joining_date')->nullable()->comment('Date employee joined the company');

            // Personal info
            $table->date('date_of_birth')->nullable()->comment('Date of birth');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('national_id')->nullable()->unique()->comment('National ID or Passport number');

            // Contact info
            $table->string('phone')->nullable();
            $table->string('emergency_contact')->nullable()->comment('Emergency phone number');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            // Optional profile picture
            $table->string('profile_pic')->nullable()->comment('Path or URL to profile picture');

            // Account status
            $table->enum('status', ['Active', 'Inactive', 'Suspended'])->default('Active');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
