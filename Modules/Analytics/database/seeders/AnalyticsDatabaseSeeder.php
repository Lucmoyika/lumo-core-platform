<?php

namespace Modules\Analytics\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Analytics\Models\InsightReport;

class AnalyticsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (InsightReport::query()->exists()) {
            return;
        }

        InsightReport::factory()->count(3)->create();
    }
}
