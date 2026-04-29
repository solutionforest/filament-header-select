<?php

namespace SolutionForest\FilamentHeaderSelect;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

class HeaderSelectPlugin implements Plugin
{
    protected array $selects = [];
    protected static array $callbacks = [];
    protected static array $optionProviders = [];
    protected string $globalRounded = '';

    public function getId(): string
    {
        return 'filament-header-select';
    }

    public static function make(): static
    {
        // Do not reuse a single container instance across Panels to avoid leaking state
        return new static();
    }

    public function rounded(string $rounded = 'rounded-full'): static
    {
        $this->globalRounded = $rounded;
        
        // Apply rounded to all existing selects (override individual settings)
        foreach ($this->selects as $select) {
            $select->rounded($rounded);
        }
        
        return $this;
    }

    public function register(Panel $panel): void
    {
        foreach ($this->selects as $select) {
            if ($callback = $select->getOnChange()) {
                $this->registerCallback($select->getName(), $callback);
            }
        }
        
        // Fixed top-center placement in the topbar end section for better positioning.
        $panel->renderHook(
            config('filament-header-select.default_hook') ?? PanelsRenderHook::TOPBAR_START,
            fn (): string => view('filament-header-select::selects', [
                'selects' => $this->selects,
            ])->render()
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function selects(array $selects): static
    {
        $this->selects = $selects;
        
        // Apply global rounded setting to all selects (override individual settings)
        if (!empty($this->globalRounded)) {
            foreach ($this->selects as $select) {
                $select->rounded($this->globalRounded);
            }
        }

        return $this;
    }

    // Position & priority setters removed – placement is fixed and not user-configurable.

    public static function executeCallback(string $selectName, mixed $value): void
    {
        if (isset(static::$callbacks[$selectName])) {
            $callback = static::$callbacks[$selectName];
            if (is_callable($callback)) {
                $result = $callback($value);
                
                // If callback returns a URL string, store it for JavaScript redirect
                if (is_string($result) && (str_starts_with($result, 'http') || str_starts_with($result, '/'))) {
                    session(['header_select_redirect_url' => $result]);
                }
            }
        }
    }

    public function registerCallback(string $selectName, \Closure $callback): void
    {
        static::$callbacks[$selectName] = $callback;
    }

    public static function getFreshOptions(string $selectName): ?array
    {
        if (isset(static::$optionProviders[$selectName])) {
            $provider = static::$optionProviders[$selectName];
            if (is_callable($provider)) {
                return $provider();
            }
        }
        return null;
    }

    public static function registerOptionProvider(string $selectName, \Closure $optionProvider): void
    {
        static::$optionProviders[$selectName] = $optionProvider;
    }
}
