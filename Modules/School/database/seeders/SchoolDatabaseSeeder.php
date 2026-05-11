<?php

namespace Modules\School\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\School\Models\AcademicProgram;

class SchoolDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (AcademicProgram::query()->exists()) {
            return;
        }

        AcademicProgram::factory()->count(3)->create();
    }
}
