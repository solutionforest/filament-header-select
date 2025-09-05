<p align="center"><a href="https://solutionforest.com" target="_blank"><img src="https://github.com/solutionforest/.github/blob/main/docs/images/sf.png?raw=true" width="150"></a></p>

## About Solution Forest

[Solution Forest](https://solutionforest.com) Web development agency based in Hong Kong. We help customers to solve their problems. We Love Open Soruces. 

We have built a collection of best-in-class products:

- [VantagoAds](https://vantagoads.com): A self manage Ads Server, Simplify Your Advertising Strategy.
- [GatherPro.events](https://gatherpro.events): A Event Photos management tools, Streamline Your Event Photos.
- [Website CMS Management](https://filamentphp.com/plugins/solution-forest-cms-website): Website CMS Management - Filament CMS Plugin
- [Filaletter](https://filaletter.solutionforest.net): Filaletter - Filament Newsletter Plugin

# Filament Header Select

A modern header navigation component for Filament Admin with **global rounded styling** and **proper color system**.

## ✨ Features

✅ **Global Rounded Styling** - Apply consistent rounded corners to all navigation elements  
✅ **Filament Color System** - Uses native Filament colors (primary, gray, info, success, warning, danger)  
✅ **URL Navigation** - Direct links to pages  
✅ **Dropdown Selects** - Interactive dropdowns with onChange callbacks  
✅ **Dynamic Options** - Refresh dropdown options from database  
✅ **No Selection Highlighting** - Clean UI without persistent highlighting  
✅ **Responsive Design** - Desktop-optimized, mobile-hidden  

<img width="3840" height="2160" alt="HeaderSelect" src="https://github.com/user-attachments/assets/ad780100-3cf4-4701-823d-2f6bc5f411c0" />

## Installation

```bash
composer require solution-forest/filament-header-select
```

## Quick Start

```php
use SolutionForest\FilamentHeaderSelect\HeaderSelectPlugin;
use SolutionForest\FilamentHeaderSelect\Components\HeaderSelect;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            HeaderSelectPlugin::make()
                ->rounded('rounded-lg') // Global rounded corners
                ->selects([
                    // URL Link
                    HeaderSelect::make('admin')
                        ->label('Admin')
                        ->url(fn() => route('filament.admin.pages.dashboard'))
                        ->color('primary'),
                        
                    // Dropdown with Navigation
                    HeaderSelect::make('agent_config')
                        ->label('Agent Config')
                        ->options([
                            'my_agent_1' => 'My Agent 2025-08-29 16:24',
                            'my_agent_2' => 'My Agent 2025-08-29 16:20',
                            'new_agent' => '+ New AI Agent',
                        ])
                        ->icon('heroicon-o-cog-6-tooth')
                        ->color('info')
                        ->keepOriginalLabel(true)
                        ->refreshable(true)
                        ->onChange(function ($value) {
                            return match($value) {
                                'my_agent_1' => '/admin/agents/my-agent-1',
                                'my_agent_2' => '/admin/agents/my-agent-2',
                                'new_agent' => '/admin/agents/create',
                                default => null,
                            };
                        }),
                ])
        ]);
}
```

## Configuration

### Global Rounded Corners
```php
HeaderSelectPlugin::make()
    ->rounded('rounded-lg')      // Large rounded corners
    ->rounded('rounded-full')    // Pill-like styling
```

### Colors
```php
HeaderSelect::make('item')
    ->color('primary')    // Indigo blue
    ->color('gray')       // Neutral gray
    ->color('info')       // Blue
    ->color('success')    // Green
    ->color('warning')    // Amber
    ->color('danger')     // Red
```

## Methods

| Method | Description | Example |
|--------|-------------|---------|
| `label(string $label)` | Set display label | `->label('Admin')` |
| `url(string\|Closure $url)` | Set navigation URL | `->url('/admin')` |
| `options(array\|Closure $options)` | Set dropdown options | `->options(['key' => 'Label'])` |
| `color(string $color)` | Set color theme | `->color('primary')` |
| `icon(string $icon)` | Set Heroicon | `->icon('heroicon-o-home')` |
| `keepOriginalLabel(bool $keep)` | Keep original label | `->keepOriginalLabel(true)` |
| `refreshable(bool $refreshable)` | Add refresh button | `->refreshable(true)` |
| `onChange(Closure $callback)` | Handle selection changes | `->onChange(fn($value) => route('page', $value))` |
## Examples

### URL Navigation
```php
HeaderSelect::make('dashboard')
    ->label('Dashboard')
    ->url(fn() => route('filament.admin.pages.dashboard'))
    ->icon('heroicon-o-home')
    ->color('primary')
```

### Dropdown with Redirect
```php
HeaderSelect::make('categories')
    ->label('Categories')
    ->options([
        'electronics' => 'Electronics',
        'clothing' => 'Clothing',
        'books' => 'Books',
    ])
    ->icon('heroicon-o-squares-2x2')
    ->color('success')
    ->onChange(function ($value) {
        return "/admin/categories/{$value}";
    })
```

### Dynamic Options from Database
```php
HeaderSelect::make('agents')
    ->label('AI Agents')
    ->options(fn() => Agent::pluck('name', 'id'))
    ->refreshable(true)
    ->color('info')
    ->onChange(function ($value) {
        return "/admin/agents/{$value}";
    })
```

## Troubleshooting

**Rounded corners not working?**
- Use global `->rounded()` on HeaderSelectPlugin  
- Clear cache: `php artisan view:clear`

**Wrong colors showing?**
- Use proper color names: `primary`, `gray`, `info`, `success`, `warning`, `danger`
- Clear cache: `php artisan config:clear`

**onChange redirects not working?**
- Return URL string from onChange callback
- Use `return '/admin/page'` instead of `redirect()->to('/admin/page')`

## License

MIT License. See [LICENSE.md](LICENSE.md) for details.

## Credits

- **[Solution Forest](https://github.com/solution-forest)** - Package development
- **[Filament](https://filamentphp.com)** - Laravel admin framework
