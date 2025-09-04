<?php

namespace SolutionForest\FilamentHeaderSelect;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

class HeaderSelectPlugin implements Plugin
{
    protected array $selects = [];
    protected static array $callbacks = [];

    public function getId(): string
    {
        return 'filament-header-select';
    }

    public static function make(): static
    {
        // Do not reuse a single container instance across Panels to avoid leaking state
        return new static();
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
            PanelsRenderHook::TOPBAR_END,
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

        return $this;
    }

    // Position & priority setters removed – placement is fixed and not user-configurable.

    public static function executeCallback(string $selectName, mixed $value): void
    {
        if (isset(static::$callbacks[$selectName])) {
            $callback = static::$callbacks[$selectName];
            if (is_callable($callback)) {
                $callback($value);
            }
        }
    }

    public function registerCallback(string $selectName, \Closure $callback): void
    {
        static::$callbacks[$selectName] = $callback;
    }
}
