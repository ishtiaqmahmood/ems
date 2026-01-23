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
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('leave_type_id')
                ->constrained('leave_types')
                ->restrictOnDelete();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->string('nid_number')->nullable();
            $table->decimal('salary', 15, 2)->nullable();
            $table->string('designation')->nullable();
            $table->integer('due_leave')->nullable();
            $table->integer('earned_leaves')->nullable();
            $table->integer('leaves_taken')->nullable();
            $table->foreignId('replacement_user_id') // Added (Selectable from users)
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('medical_certificate')->nullable();
            $table->text('reason')->nullable();
            $table->text('description')->nullable();
            $table->string('letter_pdf')->nullable();
            $table->foreignId('approved_by')->nullable()
                ->references('id')->on('users')
                ->nullOnDelete();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacations');
    }
};