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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // date fields
            $table->date('date'); // the calendar date
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // type: attendance, leave, holiday, meeting, etc.
            $table->enum('type', ['attendance', 'leave', 'holiday', 'event'])->default('event');

            // optional user association (for leave / personal attendance)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // color for display (hex)
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};