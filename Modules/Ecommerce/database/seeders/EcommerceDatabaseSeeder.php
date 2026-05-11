<?php

namespace Modules\Ecommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Ecommerce\Models\CatalogProduct;

class EcommerceDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (CatalogProduct::query()->exists()) {
            return;
        }

        CatalogProduct::factory()->count(3)->create();
    }
}
