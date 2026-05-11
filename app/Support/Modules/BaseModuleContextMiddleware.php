<?php

namespace App\Support\Modules;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

abstract class BaseModuleContextMiddleware
{
    abstract protected function moduleKey(): string;

    public function handle(Request $request, Closure $next)
    {
        View::share('moduleContext', ModuleRegistry::find($this->moduleKey()));

        return $next($request);
    }
}
