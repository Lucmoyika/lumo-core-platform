<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_grades', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('school_enrollments')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('school_teachers')->nullOnDelete();
            $table->string('subject');
            $table->string('period');
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2)->default(20);
            $table->string('grade_letter')->nullable();
            $table->text('comment')->nullable();
            $table->date('graded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_grades');
    }
};
