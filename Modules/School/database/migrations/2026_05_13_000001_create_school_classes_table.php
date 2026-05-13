<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_classes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('academic_program_id')->constrained('academic_programs')->cascadeOnDelete();
            $table->string('name');
            $table->string('level');
            $table->string('section')->nullable();
            $table->unsignedSmallInteger('capacity')->default(30);
            $table->string('room')->nullable();
            $table->string('school_year', 9)->default('2025-2026');
            $table->string('status')->default('active');
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
