<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('semester');
            $table->string('academic_year');
            $table->enum('status', ['active', 'inactive', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better query performance
            $table->index('subject_id');
            $table->index('instructor_id');
            $table->index('section_id');
            $table->index('room_id');
            $table->index(['day_of_week', 'start_time', 'end_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
