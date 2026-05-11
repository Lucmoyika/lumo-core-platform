<?php

namespace Modules\Identity\Providers;

use App\Support\Modules\ModuleServiceProvider;

class IdentityServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Identity';
    protected string $nameLower = 'identity';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);
        $sourceLangPath = module_path($this->name, 'lang');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom($sourceLangPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($sourceLangPath);
        }
    }
}
