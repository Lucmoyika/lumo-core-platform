<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_transport_routes', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->foreignId('vehicle_id')->nullable()->constrained('school_vehicles')->nullOnDelete();
            $table->time('departure_time');
            $table->time('arrival_time')->nullable();
            $table->text('description')->nullable();
            $table->decimal('monthly_fee', 8, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_transport_routes');
    }
};
