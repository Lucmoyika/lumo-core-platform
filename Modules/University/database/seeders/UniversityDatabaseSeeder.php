<?php

namespace Modules\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\University\Models\UniversityProgram;

class UniversityDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (UniversityProgram::query()->exists()) {
            return;
        }

        UniversityProgram::factory()->count(3)->create();
    }
}
