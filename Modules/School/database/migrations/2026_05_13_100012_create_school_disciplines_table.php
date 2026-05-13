<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_disciplines', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('school_enrollments')->cascadeOnDelete();
            $table->foreignId('reported_by')->nullable()->constrained('school_teachers')->nullOnDelete();
            $table->date('incident_date');
            $table->string('incident_type')->default('misconduct');
            $table->text('description');
            $table->string('sanction')->nullable();
            $table->date('sanction_start')->nullable();
            $table->date('sanction_end')->nullable();
            $table->string('status')->default('open');
            $table->boolean('parent_notified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_disciplines');
    }
};
