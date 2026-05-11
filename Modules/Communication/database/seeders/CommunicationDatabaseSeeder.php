<?php

namespace Modules\Communication\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Communication\Models\CommunicationChannel;

class CommunicationDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (CommunicationChannel::query()->exists()) {
            return;
        }

        CommunicationChannel::factory()->count(3)->create();
    }
}
