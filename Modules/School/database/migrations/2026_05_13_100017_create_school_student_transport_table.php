<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_student_transport', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained('school_students')->cascadeOnDelete();
            $table->foreignId('route_id')->constrained('school_transport_routes')->cascadeOnDelete();
            $table->string('academic_year');
            $table->string('pickup_point')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'route_id', 'academic_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_student_transport');
    }
};
