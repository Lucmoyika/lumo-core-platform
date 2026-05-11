<?php

namespace Modules\Logistics\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Logistics\Models\DeliveryShipment;

class LogisticsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (DeliveryShipment::query()->exists()) {
            return;
        }

        DeliveryShipment::factory()->count(3)->create();
    }
}
