<?php

namespace App\Providers;

use App\Support\Modules\ModuleRegistry;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        foreach (ModuleRegistry::all() as $module) {
            Gate::policy($module['model'], $module['policy']);
        }

        View::share('platformModules', ModuleRegistry::navigation());
    }
}
