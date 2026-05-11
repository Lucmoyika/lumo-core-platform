<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\Models\WalletTransaction;

class PaymentDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (WalletTransaction::query()->exists()) {
            return;
        }

        WalletTransaction::factory()->count(3)->create();
    }
}
