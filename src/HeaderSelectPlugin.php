<?php

namespace SolutionForest\FilamentHeaderSelect;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\View\PanelsRenderHook;

class HeaderSelectPlugin implements Plugin
{
    use EvaluatesClosures;

    protected array $selects = [];
    protected string $position = 'before_user_menu';
    protected static array $callbacks = [];
    protected int $priority = 0;

    public function getId(): string
    {
        return 'filament-header-select';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        // Register callbacks for all selects
        foreach ($this->selects as $select) {
            $onChange = $select->getOnChange();
            if ($onChange) {
                $this->registerCallback($select->getName(), $onChange);
            }
        }
        
        // Use high priority to ensure proper loading order (negative numbers load first)
        $panel->renderHook(
            $this->getRenderHookName(),
            fn (): string => view('filament-header-select::selects', [
                'selects' => $this->selects,
            ])->render(),
            scopes: null
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

    public function position(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function priority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    protected function getRenderHookName(): string
    {
        return match ($this->position) {
            'before_user_menu' => PanelsRenderHook::USER_MENU_BEFORE,
            'after_user_menu' => PanelsRenderHook::USER_MENU_AFTER,
            'global_search_before' => PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            'global_search_after' => PanelsRenderHook::GLOBAL_SEARCH_AFTER,
            'topbar_start' => PanelsRenderHook::TOPBAR_START,
            'topbar_end' => PanelsRenderHook::TOPBAR_END,
            'topbar_center' => PanelsRenderHook::GLOBAL_SEARCH_AFTER, // Use this for center positioning
            'topbar_before' => PanelsRenderHook::TOPBAR_BEFORE,
            'topbar_after' => PanelsRenderHook::TOPBAR_AFTER,
            'topbar_logo_after' => PanelsRenderHook::TOPBAR_LOGO_AFTER,
            'topbar_logo_before' => PanelsRenderHook::TOPBAR_LOGO_BEFORE,
            'body_start' => PanelsRenderHook::BODY_START,
            'body_end' => PanelsRenderHook::BODY_END,
            default => PanelsRenderHook::USER_MENU_BEFORE,
        };
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

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
