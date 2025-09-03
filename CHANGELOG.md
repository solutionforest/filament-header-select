# Changelog

All notable changes to `filament-header-select` will be documented in this file.

## v1.1.0 - 2025-09-03

### Changed
- **BREAKING**: Switched from PHPUnit to Pest 4 for testing
- **BREAKING**: Removed custom AJAX routes - now uses Livewire for state management
- Improved render hook positioning based on Filament 4.x documentation
- Better session persistence with Livewire integration

### Added
- Livewire component for reactive state management
- Better event system with Livewire dispatch
- Improved error handling and conditional service registration

### Removed
- Custom HTTP controller and routes (replaced with Livewire)
- Unnecessary JavaScript AJAX calls
- Complex route registration

### Fixed
- Render hooks now properly target correct Filament panel positions
- Session persistence works more reliably with Livewire
- Tests now use Pest 4 with proper setup

## v1.0.0 - 2025-09-03

### Added
- Initial release
- Basic header select component for Filament admin panels
- Session storage for selected values
- Multiple positioning options (before/after user menu, global search, topbar)
- Event system for selection changes
- Icon support with Heroicons
- Visibility and disabled state conditions
- Simple, clean HTML select implementation
- PHP 8.1+ and Filament 3.0+ support

### Core Features
- HeaderSelect component with fluent API
- HeaderSelectPlugin for easy registration
- Automatic session persistence
- JavaScript events for client-side handling
- Server-side onChange callbacks
- Multiple selects support
- Dark mode compatibility

### Philosophy
- No over-engineering - simple, direct implementation
- Minimal configuration bloat
- Focus on core data flow and user experience
- Clean separation of concerns
