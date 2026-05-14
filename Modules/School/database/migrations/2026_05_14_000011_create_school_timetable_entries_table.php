<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_timetable_entries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('school_teachers')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('school_subjects')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->time('starts_at');
            $table->time('ends_at');
            $table->string('room')->nullable();
            $table->timestamps();

            $table->index(['teacher_id', 'day_of_week', 'starts_at', 'ends_at'], 'school_timetable_teacher_time_idx');
            $table->index(['school_class_id', 'day_of_week', 'starts_at', 'ends_at'], 'school_timetable_class_time_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_timetable_entries');
    }
};
