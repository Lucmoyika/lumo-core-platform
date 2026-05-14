<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_exams', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('school_subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('school_teachers')->nullOnDelete();
            $table->string('name');
            $table->string('period');
            $table->date('exam_date');
            $table->decimal('max_score', 5, 2)->default(20);
            $table->timestamps();
        });

        Schema::table('school_grades', function (Blueprint $table): void {
            $table->foreignId('exam_id')->nullable()->after('teacher_id')->constrained('school_exams')->nullOnDelete();
        });

        Schema::create('school_report_cards', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('school_enrollments')->cascadeOnDelete();
            $table->string('period');
            $table->decimal('average', 5, 2)->default(0);
            $table->unsignedInteger('rank')->nullable();
            $table->text('teacher_comment')->nullable();
            $table->date('generated_at');
            $table->timestamps();

            $table->unique(['enrollment_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_report_cards');

        Schema::table('school_grades', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('exam_id');
        });

        Schema::dropIfExists('school_exams');
    }
};
