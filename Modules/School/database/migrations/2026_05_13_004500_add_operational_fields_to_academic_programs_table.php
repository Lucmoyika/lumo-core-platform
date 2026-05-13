<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('academic_programs', function (Blueprint $table): void {
            $table->string('level')->default('primaire')->after('audience');
            $table->unsignedSmallInteger('duration_months')->nullable()->after('level');
            $table->unsignedDecimal('annual_fee', 12, 2)->nullable()->after('duration_months');
            $table->boolean('admission_open')->default(false)->after('is_public');
            $table->date('admission_deadline')->nullable()->after('admission_open');
        });
    }

    public function down(): void
    {
        Schema::table('academic_programs', function (Blueprint $table): void {
            $table->dropColumn([
                'level',
                'duration_months',
                'annual_fee',
                'admission_open',
                'admission_deadline',
            ]);
        });
    }
};
