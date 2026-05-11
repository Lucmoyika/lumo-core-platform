<?php

namespace Modules\Communication\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsureCommunicationContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'communication';
    }
}
