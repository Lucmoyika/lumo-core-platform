<?php

namespace Modules\Payment\Repositories;

use App\Support\Modules\BaseModuleRepository;
use Modules\Payment\Models\WalletTransaction;

class WalletTransactionRepository extends BaseModuleRepository
{
    public function __construct(WalletTransaction $model)
    {
        parent::__construct($model);
    }
}
