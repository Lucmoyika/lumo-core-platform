<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_invoices', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('school_enrollments')->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('currency', 3)->default('CDF');
            $table->date('due_date');
            $table->string('status')->default('unpaid');
            $table->timestamps();
        });

        Schema::create('school_payments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('invoice_id')->constrained('school_invoices')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('method')->default('cash');
            $table->string('reference')->nullable();
            $table->date('paid_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_payments');
        Schema::dropIfExists('school_invoices');
    }
};
