<?php

namespace Modules\Companies\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsureCompaniesContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'companies';
    }
}
