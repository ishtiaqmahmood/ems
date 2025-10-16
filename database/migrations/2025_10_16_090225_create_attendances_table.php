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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // Link to user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Attendance date
            $table->date('date')->index();

            // Attendance status
            $table->enum('status', ['Present', 'Absent', 'Leave'])->default('Present');

            // Optional check-in and check-out times
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();

            // Total hours worked in decimal (optional)
            $table->decimal('total_hours', 5, 2)->nullable()->comment('Total hours worked');

            // Aggregated counters
            $table->integer('total_days')->default(0)->comment('Total days worked up to this date');
            $table->integer('total_leaves')->default(0)->comment('Total leaves taken up to this date');
            $table->integer('total_absents')->default(0)->comment('Total absents up to this date');
            // Track created and updated timestamps
            $table->timestamps();

            // Optional unique constraint to avoid duplicate attendance entries per user per day
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
