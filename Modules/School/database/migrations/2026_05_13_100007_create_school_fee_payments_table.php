<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_fee_payments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('school_enrollments')->cascadeOnDelete();
            $table->foreignId('fee_structure_id')->nullable()->constrained('school_fee_structures')->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('CDF');
            $table->string('payment_method')->default('cash');
            $table->string('reference')->nullable();
            $table->date('paid_at');
            $table->string('received_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_fee_payments');
    }
};
