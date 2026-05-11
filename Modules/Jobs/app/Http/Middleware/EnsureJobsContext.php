<?php

namespace Modules\Jobs\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsureJobsContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'jobs';
    }
}
