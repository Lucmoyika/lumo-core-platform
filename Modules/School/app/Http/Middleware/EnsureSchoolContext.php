<?php

namespace Modules\School\Http\Middleware;

use App\Support\Modules\BaseModuleContextMiddleware;

class EnsureSchoolContext extends BaseModuleContextMiddleware
{
    protected function moduleKey(): string
    {
        return 'school';
    }
}
