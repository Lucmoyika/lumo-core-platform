<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Jobs\Models\JobListing;

class JobsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (JobListing::query()->exists()) {
            return;
        }

        JobListing::factory()->count(3)->create();
    }
}
