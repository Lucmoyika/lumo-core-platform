<?php

namespace Modules\Logistics\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsureLogisticsContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'logistics';
    }
}
