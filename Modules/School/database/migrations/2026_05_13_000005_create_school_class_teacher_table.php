<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_class_teacher', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('school_teachers')->cascadeOnDelete();
            $table->string('subject');
            $table->string('role')->default('teacher');
            $table->timestamps();

            $table->unique(['school_class_id', 'teacher_id', 'subject']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_class_teacher');
    }
};
