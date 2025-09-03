<?php

namespace SolutionForest\FilamentHeaderSelect;

use Illuminate\Support\ServiceProvider;

class HeaderSelectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-header-select.php', 'filament-header-select');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-header-select');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/filament-header-select.php' => config_path('filament-header-select.php'),
            ], 'filament-header-select-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-header-select'),
            ], 'filament-header-select-views');

            $this->publishes([
                __DIR__ . '/../resources/css' => public_path('vendor/filament-header-select'),
            ], 'filament-header-select-assets');
        }

        // Register CSS styles with Filament
        if (class_exists(\Filament\Support\Facades\FilamentAsset::class)) {
            \Filament\Support\Facades\FilamentAsset::register([
                \Filament\Support\Assets\Css::make('filament-header-select', __DIR__.'/../resources/css/header-select.css'),
            ], 'solution-forest/filament-header-select');
        }
    }
}
