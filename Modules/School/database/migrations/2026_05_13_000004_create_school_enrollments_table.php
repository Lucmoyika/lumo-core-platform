<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained('school_students')->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->string('school_year', 9)->default('2025-2026');
            $table->string('status')->default('active');
            $table->decimal('fee_amount', 10, 2)->default(0);
            $table->decimal('fee_paid', 10, 2)->default(0);
            $table->string('fee_currency', 3)->default('CDF');
            $table->date('enrolled_at')->nullable();
            $table->json('notes')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'school_class_id', 'school_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_enrollments');
    }
};
