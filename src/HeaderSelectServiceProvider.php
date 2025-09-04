<?php

namespace SolutionForest\FilamentHeaderSelect;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class HeaderSelectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-header-select.php', 'filament-header-select');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-header-select');

        // Register Livewire component alias (used by @livewire('header-select-component'))
        Livewire::component('header-select-component', \SolutionForest\FilamentHeaderSelect\Livewire\HeaderSelectComponent::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/filament-header-select.php' => config_path('filament-header-select.php'),
            ], 'filament-header-select-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-header-select'),
            ], 'filament-header-select-views');

        }

    }
}
