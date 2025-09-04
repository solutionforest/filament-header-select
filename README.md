# Filament Header Select Package

A powerful Laravel package that adds customizable navigation elements to the Filament admin panel header. Perfect for multi-tenant applications, context switching, or creating navigation bars similar to modern admin interfaces.

🎯 **Features multi-type navigation** - Supports dropdowns, page links, and external URLs in a single floating navigation bar!

## Features

- 🎯 **Easy Integration** - Simple installation and configuration
- 🚀 **Multiple Navigation Types** - Dropdowns, page links, and external URLs
- 🎨 **Fully Customizable** - Customize appearance, behavior, positioning, and colors
- 🔄 **Dynamic Options** - Load options from database, API, or static arrays
- 🌗 **Dark Mode Support** - Seamlessly works with Filament's dark mode
- 📱 **Responsive Design** - Mobile-friendly floating navigation bar
- 🔌 **Event Driven** - Emit and listen to selection change events
- 🏗️ **Multiple Instances** - Add multiple navigation elements in the header
- 🔐 **Permission Support** - Built-in authorization support via `visible()` method
- 🧪 **Pure CSS** - No external dependencies, self-contained styling
- 🎯 **Modern UI** - Matches reference designs with pill-shaped navigation
- 🎨 **Color Themes** - Support for primary, success, warning, and danger color variants
- 📏 **Icon Sizing** - Filament-native icon sizing system with spacing control

## Requirements

- PHP 8.1+
- Laravel 10.0+
- Filament 3.0+ or 4.0+

## Installation

```bash
composer require solution-forest/filament-header-select
```

## Usage

Add to your Panel Provider:

```php
use SolutionForest\FilamentHeaderSelect\HeaderSelectPlugin;
use SolutionForest\FilamentHeaderSelect\Components\HeaderSelect;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            HeaderSelectPlugin::make()
                ->position('body_start') // Creates floating top navigation
                ->selects([
                    // Page Navigation Link
                    HeaderSelect::make('admin')
                        ->label('Admin')
                        ->url(fn () => route('filament.admin.pages.dashboard'))
                        ->icon('heroicon-o-home'),
                        
                    // Dropdown Select
                    HeaderSelect::make('tenant')
                        ->label('Tenant')
                        ->options(fn () => Tenant::pluck('name', 'id'))
                        ->default(fn () => session('tenant_id'))
                        ->placeholder('Select Tenant')
                        ->onChange(function ($value) {
                            session(['tenant_id' => $value]);
                        }),
                        
                    // External Link
                    HeaderSelect::make('docs')
                        ->label('Documentation')
                        ->url('https://filamentphp.com/docs')
                        ->newTab(true)
                        ->icon('heroicon-o-document-text'),
                ]),
        ]);
}
```

## Navigation Types

### 1. Page Links
Direct navigation to internal pages with automatic active state detection:

```php
HeaderSelect::make('dashboard')
    ->label('Dashboard')
    ->url(fn () => route('filament.admin.pages.dashboard'))
    ->icon('heroicon-o-home')
```

### 2. Dropdown Selects
Traditional dropdowns with options and change callbacks:

```php
HeaderSelect::make('tenant')
    ->label('Current Tenant')
    ->options(fn () => auth()->user()->tenants()->pluck('name', 'id'))
    ->default(fn () => session('current_tenant_id'))
    ->placeholder('Select Tenant')
    ->icon('heroicon-o-building-office')
    ->onChange(function ($value) {
        session(['current_tenant_id' => $value]);
        // Switch context
        app(TenantManager::class)->switch($value);
    })
```

### 3. External Links
Links to external sites with optional new tab opening:

```php
HeaderSelect::make('docs')
    ->label('Documentation')
    ->url('https://filamentphp.com/docs')
    ->newTab(true) // Opens in new tab
    ->icon('heroicon-o-document-text')
```

## Examples

### Complete Navigation Bar
Create a comprehensive navigation bar with mixed elements:

```php
HeaderSelectPlugin::make()
    ->position('body_start')
    ->selects([
        // Primary navigation - always active
        HeaderSelect::make('admin')
            ->label('Admin')
            ->url(fn () => route('filament.admin.pages.dashboard'))
            ->icon('heroicon-o-home'),
            
        // Secondary page
        HeaderSelect::make('knowledge')
            ->label('Knowledge Base')
            ->url('/admin/knowledge')
            ->icon('heroicon-o-book-open'),
            
        // Context switcher dropdown
        HeaderSelect::make('tenant')
            ->label('Current Workspace')
            ->options(fn () => auth()->user()->workspaces()->pluck('name', 'id'))
            ->placeholder('Select Workspace')
            ->icon('heroicon-o-building-office')
            ->onChange(function ($value) {
                session(['workspace_id' => $value]);
                return redirect()->back();
            }),
            
        // External documentation
        HeaderSelect::make('help')
            ->label('Help')
            ->url('https://docs.yourapp.com')
            ->newTab(true)
            ->icon('heroicon-o-question-mark-circle'),
            
        // Admin-only dropdown
        HeaderSelect::make('admin_tools')
            ->label('Admin Tools')
            ->options([
                'maintenance' => 'Maintenance Mode',
                'debug' => 'Debug Mode',
                'logs' => 'View Logs',
            ])
            ->visible(fn () => auth()->user()?->is_admin)
            ->icon('heroicon-o-cog-6-tooth')
            ->onChange(function ($value) {
                match($value) {
                    'maintenance' => app()->call([MaintenanceController::class, 'toggle']),
                    'debug' => session(['debug_mode' => !session('debug_mode')]),
                    'logs' => redirect()->to('/admin/logs'),
                };
            }),
    ])
```

### Multi-tenant Application

```php
HeaderSelect::make('tenant')
    ->label('Current Tenant')
    ->options(fn () => auth()->user()->tenants()->pluck('name', 'id'))
    ->default(fn () => session('current_tenant_id'))
    ->icon('heroicon-o-building-office')
    ->onChange(function ($value) {
        session(['current_tenant_id' => $value]);
        // Switch context
        app(TenantManager::class)->switch($value);
    })
```

### Environment Switcher

```php
HeaderSelect::make('environment')
    ->label('Environment')
    ->options(['production' => 'Production', 'staging' => 'Staging'])
    ->visible(fn () => auth()->user()->is_admin)
    ->onChange(fn ($value) => session(['environment' => $value]))
```

### Language Switcher

```php
HeaderSelect::make('locale')
    ->label('Language')
    ->options(['en' => 'English', 'es' => 'Español', 'fr' => 'Français'])
    ->default(app()->getLocale())
    ->onChange(function ($value) {
        session(['locale' => $value]);
        return redirect()->back();
    })
```

## API Reference

### HeaderSelect Methods

| Method | Description | Example |
|--------|-------------|---------|
| `make(string $name)` | Create select with unique name | `HeaderSelect::make('tenant')` |
| `label(string $label)` | Set display label | `->label('Current Tenant')` |
| `options(array\|Closure $options)` | Set dropdown options | `->options(['a' => 'Option A'])` |
| `url(string\|Closure $url)` | Set navigation URL | `->url('/admin/dashboard')` |
| `newTab(bool $newTab)` | Open URL in new tab | `->newTab(true)` |
| `default(mixed $default)` | Set default value | `->default('option_a')` |
| `placeholder(string $placeholder)` | Set placeholder text | `->placeholder('Select...')` |
| `icon(string $icon)` | Set Heroicon | `->icon('heroicon-o-home')` |
| `iconSize(string $size)` | Set icon size | `->iconSize('sm')` |
| `iconSpacing(string $spacing)` | Set icon-text spacing | `->iconSpacing('relaxed')` |
| `visible(bool\|Closure $condition)` | Set visibility | `->visible(fn() => auth()->user()->is_admin)` |
| `disabled(bool\|Closure $condition)` | Set disabled state | `->disabled(false)` |
| `onChange(Closure $callback)` | Handle selection changes | `->onChange(fn($value) => session(['key' => $value]))` |

### HeaderSelectPlugin Methods

| Method | Description | Example |
|--------|-------------|---------|
| `make()` | Create plugin instance | `HeaderSelectPlugin::make()` |
| `position(string $position)` | Set render position | `->position('body_start')` |
| `selects(array $selects)` | Set navigation elements | `->selects([...])` |

### Icon Sizing

The package uses Filament's native icon sizing system:

- `xs` - Extra small icons (`calc(var(--spacing) * 3)`)
- `sm` - Small icons (`calc(var(--spacing) * 4)`) - **Default**
- `md` - Medium icons (`calc(var(--spacing) * 5)`)
- `lg` - Large icons (`calc(var(--spacing) * 6)`)
- `xl` - Extra large icons (`calc(var(--spacing) * 7)`)
- `2xl` - 2X large icons (`calc(var(--spacing) * 8)`)

```php
HeaderSelect::make('admin')
    ->icon('heroicon-o-home')
    ->iconSize('lg') // Uses Filament's fi-icon fi-size-lg classes
    ->iconSpacing('relaxed') // More space between icon and text
```

### Icon Spacing Options

Control the spacing between icons and text:

- `tight` - 0.5rem gap (close spacing)
- `normal` - 0.75rem gap (default, balanced spacing)  
- `relaxed` - 1rem gap (more breathing room)

```php
HeaderSelect::make('docs')
    ->icon('heroicon-o-document-text')
    ->iconSpacing('relaxed') // Perfect for important navigation items
```

### Available Positions

- `body_start` - Fixed floating navigation at top (recommended)
- `topbar_start` - Within Filament's topbar at start
- `topbar_end` - Within Filament's topbar at end
- `before_user_menu` - Before user menu
- `after_user_menu` - After user menu

## Styling

The package includes custom CSS that creates a floating navigation bar with:

- **Fixed positioning** at the top center of the viewport
- **Pill-shaped design** with rounded corners
- **Hover effects** and active states
- **Dark mode support** 
- **Responsive design** (hidden on mobile)
- **Smooth transitions** for all interactions
- **Icon spacing** using CSS gap for consistent alignment
- **Text truncation** for long labels (max 200px width)
- **Flexible sizing** that adapts to content

### Size Considerations

The navigation is optimized for desktop use and automatically adjusts:

- **Button width**: Maximum 200px with text truncation
- **Icon spacing**: 0.5rem gap between icon and text
- **Responsive**: Hidden on mobile devices (< 768px)
- **Z-index**: High value (70) to stay above other content

### Best Practices

1. **Keep labels short** - Long text will be truncated with ellipsis
2. **Limit navigation items** - 3-6 items work best for visual balance
3. **Use meaningful icons** - Heroicons work best for consistency
4. **Group related functions** - Use dropdowns for related options
5. **Test responsive behavior** - Navigation hides on mobile automatically

## Plugin Loading Order

**Important**: The HeaderSelectPlugin must be loaded **first** before other plugins to ensure proper initialization:

```php
// ✅ CORRECT - HeaderSelect first
->plugin(HeaderSelectPlugin::make()->...)
->plugin(SpatieTranslatablePlugin::make()->...)

// ❌ WRONG - Will cause conflicts
->plugin(SpatieTranslatablePlugin::make()->...)
->plugin(HeaderSelectPlugin::make()->...)
```

This ensures all render hooks and assets are properly registered.

## Navigation Element Types

The component automatically detects the type of navigation element based on the methods used:

1. **Dropdown Select**: Has `options()` method - creates dropdown with selectable options
2. **URL Link**: Has `url()` method - creates navigation link (internal or external)  
3. **Action Button**: Has `onChange()` but no `options()` or `url()` - creates action button

## Color Themes

The component supports multiple color themes to match your design needs:

```php
HeaderSelectPlugin::make()
    ->selects([
        // Primary theme (default blue)
        HeaderSelect::make('dashboard')
            ->label('Dashboard')
            ->url('/admin')
            ->color('primary'),
            
        // Success theme (green)
        HeaderSelect::make('tenant')
            ->label('Tenant')
            ->options(fn () => Tenant::pluck('name', 'id'))
            ->color('success'),
            
        // Warning theme (amber)
        HeaderSelect::make('settings')
            ->label('Settings')
            ->url('/settings')
            ->color('warning'),
            
        // Danger theme (red)
        HeaderSelect::make('emergency')
            ->label('Emergency')
            ->url('/emergency')
            ->color('danger')
    ])
```

Available color themes:
- `primary` - Blue theme (default)
- `success` - Green theme
- `warning` - Amber theme  
- `danger` - Red theme

Each theme includes hover effects and maintains consistency with Filament's design system.

## Events

Listen to selection changes:

```javascript
document.addEventListener('header-select-changed', function (event) {
    console.log(event.detail); // { select: 'tenant', value: '123', oldValue: '456' }
});
```

## Testing

```bash
composer test
```

## License

MIT License. See [LICENSE.md](LICENSE.md) for details.

## Credits

- [Solution Forest](https://github.com/solution-forest)
- Built for [Filament](https://filamentphp.com)