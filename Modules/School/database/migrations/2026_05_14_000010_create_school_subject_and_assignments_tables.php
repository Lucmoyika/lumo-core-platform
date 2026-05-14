<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_subjects', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 20)->unique();
            $table->unsignedTinyInteger('coefficient')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('school_teacher_subject', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('teacher_id')->constrained('school_teachers')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('school_subjects')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['teacher_id', 'subject_id']);
        });

        Schema::create('school_class_subject_teacher', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('school_subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('school_teachers')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['school_class_id', 'subject_id', 'teacher_id'], 'school_class_subject_teacher_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_class_subject_teacher');
        Schema::dropIfExists('school_teacher_subject');
        Schema::dropIfExists('school_subjects');
    }
};
