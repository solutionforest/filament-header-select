<?php

use Filament\View\PanelsRenderHook;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Classes
    |--------------------------------------------------------------------------
    |
    | Default CSS classes to apply to all header selects (applies to any
    | fallback native <select> implementation). The plugin position is now
    | fixed and not configurable.
    |
    */
    'default_classes' => 'min-w-[200px]',
    'default_hook' => PanelsRenderHook::TOPBAR_START,
];
