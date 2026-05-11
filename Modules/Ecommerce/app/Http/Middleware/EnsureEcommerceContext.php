<?php

namespace Modules\Ecommerce\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsureEcommerceContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'ecommerce';
    }
}
