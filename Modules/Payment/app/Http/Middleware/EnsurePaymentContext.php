<?php

namespace Modules\Payment\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsurePaymentContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'payment';
    }
}
