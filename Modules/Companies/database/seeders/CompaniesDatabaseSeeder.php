<?php

namespace Modules\Companies\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Companies\Models\CompanyProfile;

class CompaniesDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (CompanyProfile::query()->exists()) {
            return;
        }

        CompanyProfile::factory()->count(3)->create();
    }
}
