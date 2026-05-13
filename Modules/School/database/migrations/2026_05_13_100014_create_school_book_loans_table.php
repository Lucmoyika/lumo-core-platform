<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_book_loans', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('book_id')->constrained('school_books')->cascadeOnDelete();
            $table->string('borrower_type')->default('student');
            $table->unsignedBigInteger('borrower_id');
            $table->date('loan_date');
            $table->date('due_date');
            $table->date('returned_at')->nullable();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_book_loans');
    }
};
