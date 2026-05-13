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
            $table->string('name');
            $table->foreignId('academic_year_id')->nullable()->constrained('school_academic_years')->nullOnDelete();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->string('subject');
            $table->string('exam_type')->default('exam');
            $table->string('period');
            $table->decimal('max_score', 5, 2)->default(20);
            $table->date('date')->nullable();
            $table->string('status')->default('scheduled');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_exams');
    }
};
