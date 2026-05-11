<?php

namespace Modules\University\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsureUniversityContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'university';
    }
}
