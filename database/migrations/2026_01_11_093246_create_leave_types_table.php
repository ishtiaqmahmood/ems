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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();              // earned_full_pay
            $table->string('name_bn');                     // গড় বেতনে অর্জিত ছুটি
            $table->string('name_en');                     // Earned Leave (Full Pay)

            $table->integer('max_duration')->nullable();   // numeric value
            $table->enum('duration_unit', ['day', 'month', 'year'])->default('day');

            $table->boolean('requires_medical')->default(false);
            $table->boolean('paid')->default(true);
            $table->boolean('lifetime_limit')->default(false);

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
