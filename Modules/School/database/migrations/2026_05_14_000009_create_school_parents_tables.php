<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_parents', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('relationship')->nullable();
            $table->timestamps();
        });

        Schema::create('school_parent_student', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')->constrained('school_parents')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('school_students')->cascadeOnDelete();
            $table->string('relationship')->nullable();
            $table->timestamps();

            $table->unique(['parent_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_parent_student');
        Schema::dropIfExists('school_parents');
    }
};
