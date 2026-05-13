<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_fee_structures', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->foreignId('academic_program_id')->constrained('academic_programs')->cascadeOnDelete();
            $table->string('academic_year');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('CDF');
            $table->string('fee_type')->default('tuition');
            $table->date('due_date')->nullable();
            $table->boolean('is_mandatory')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_fee_structures');
    }
};
