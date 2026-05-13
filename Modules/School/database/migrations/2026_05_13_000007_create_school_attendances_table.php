<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_attendances', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('school_enrollments')->cascadeOnDelete();
            $table->date('date');
            $table->string('status')->default('present');
            $table->text('reason')->nullable();
            $table->boolean('notified')->default(false);
            $table->timestamps();

            $table->unique(['enrollment_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_attendances');
    }
};
