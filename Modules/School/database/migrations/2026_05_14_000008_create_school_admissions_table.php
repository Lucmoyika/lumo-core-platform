<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_admissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained('school_students')->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->string('status')->default('approved');
            $table->date('applied_at');
            $table->date('approved_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_admissions');
    }
};
