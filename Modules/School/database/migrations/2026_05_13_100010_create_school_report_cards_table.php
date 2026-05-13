<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_report_cards', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('school_enrollments')->cascadeOnDelete();
            $table->string('period');
            $table->decimal('average', 5, 2)->nullable();
            $table->unsignedSmallInteger('rank')->nullable();
            $table->unsignedSmallInteger('total_students')->nullable();
            $table->text('general_comment')->nullable();
            $table->text('teacher_comment')->nullable();
            $table->text('director_comment')->nullable();
            $table->string('conduct')->nullable();
            $table->unsignedSmallInteger('absences')->default(0);
            $table->timestamp('generated_at')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->unique(['enrollment_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_report_cards');
    }
};
