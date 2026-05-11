<?php

namespace Modules\Payment\Services;

use App\Support\Modules\BaseModuleService;
use Modules\Payment\Repositories\WalletTransactionRepository;

class WalletTransactionService extends BaseModuleService
{
    public function __construct(WalletTransactionRepository $repository)
    {
        parent::__construct($repository, 'payment');
    }
}
