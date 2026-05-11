<?php

namespace Modules\Analytics\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsureAnalyticsContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'analytics';
    }
}
