@once
<style>
/* Filament Header Select - Centered Navigation Bar */
.filament-header-select {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    z-index: 50;
    display: none;
}

@media (min-width: 768px) {
    .filament-header-select {
        display: block;
    }
}

.filament-header-select-nav {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(229, 231, 235, 1);
    border-radius: 2rem; /* Much more rounded like your UI */
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
    backdrop-filter: blur(8px);
    min-height: 2.5rem;
}

.dark .filament-header-select-nav {
    background: rgba(31, 41, 55, 0.95);
    border-color: rgba(75, 85, 99, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2), 0 1px 2px rgba(0, 0, 0, 0.12);
}

.filament-header-select-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: rgb(107, 114, 128);
    background-color: transparent;
    border: none;
    border-radius: 1.5rem; /* More rounded buttons */
    cursor: pointer;
    transition: all 150ms ease-in-out;
    white-space: nowrap;
    text-decoration: none;
    min-height: 2rem;
    position: relative;
    flex-shrink: 0;
    overflow: hidden; /* Ensure content stays within button bounds */
}

.filament-header-select-button:hover {
    background-color: rgba(243, 244, 246, 1);
    color: rgb(75, 85, 99);
}

.filament-header-select-button-active {
    /* Removed active state styling - no highlighting after selection */
    background-color: transparent;
    color: rgb(107, 114, 128);
    font-weight: 500;
}

.dark .filament-header-select-button-active {
    background-color: transparent;
    color: rgb(156, 163, 175);
}

.dark .filament-header-select-button {
    color: rgb(156, 163, 175);
}

.dark .filament-header-select-button:hover {
    background-color: rgba(55, 65, 81, 1);
    color: rgb(209, 213, 219);
}

/* Icon sizing for consistency */
.fi-icon.fi-size-sm {
    height: 1rem;
    width: 1rem;
    flex-shrink: 0;
}

/* Rounded corner utilities - Applied directly to buttons */
.filament-header-select-button.rounded-none { border-radius: 0px; }
.filament-header-select-button.rounded { border-radius: 0.375rem; }
.filament-header-select-button.rounded-md { border-radius: 0.375rem; }
.filament-header-select-button.rounded-lg { border-radius: 0.5rem; }
.filament-header-select-button.rounded-xl { border-radius: 0.75rem; }
.filament-header-select-button.rounded-2xl { border-radius: 1rem; }
.filament-header-select-button.rounded-3xl { border-radius: 1.5rem; }
.filament-header-select-button.rounded-full { border-radius: 9999px; }

/* Color variants - Using Filament's default color system */
.filament-header-select-button.color-primary {
    background-color: rgb(99, 102, 241); /* Filament primary (indigo) */
    color: white;
    font-weight: 600;
    border: 1px solid rgb(99, 102, 241);
}

.filament-header-select-button.color-primary:hover {
    background-color: rgb(79, 70, 229);
    border-color: rgb(79, 70, 229);
}

.filament-header-select-button.color-gray {
    background-color: rgb(107, 114, 128); /* Filament gray */
    color: white;
    font-weight: 500;
    border: 1px solid rgb(107, 114, 128);
}

.filament-header-select-button.color-gray:hover {
    background-color: rgb(75, 85, 99);
    border-color: rgb(75, 85, 99);
}

.filament-header-select-button.color-info {
    background-color: rgb(59, 130, 246); /* Filament info (blue) */
    color: white;
    font-weight: 600;
    border: 1px solid rgb(59, 130, 246);
}

.filament-header-select-button.color-info:hover {
    background-color: rgb(37, 99, 235);
    border-color: rgb(37, 99, 235);
}

.filament-header-select-button.color-success {
    background-color: rgb(34, 197, 94); /* Filament success (green) */
    color: white;
    font-weight: 600;
    border: 1px solid rgb(34, 197, 94);
}

.filament-header-select-button.color-success:hover {
    background-color: rgb(22, 163, 74);
    border-color: rgb(22, 163, 74);
}

.filament-header-select-button.color-warning {
    background-color: rgb(245, 158, 11); /* Filament warning (amber) */
    color: white;
    font-weight: 600;
    border: 1px solid rgb(245, 158, 11);
}

.filament-header-select-button.color-warning:hover {
    background-color: rgb(217, 119, 6);
    border-color: rgb(217, 119, 6);
}

.filament-header-select-button.color-danger {
    background-color: rgb(239, 68, 68); /* Filament danger (red) */
    color: white;
    font-weight: 600;
    border: 1px solid rgb(239, 68, 68);
}

.filament-header-select-button.color-danger:hover {
    background-color: rgb(220, 38, 38);
    border-color: rgb(220, 38, 38);
}

.filament-header-select-icon {
    height: 0.75rem;
    width: 0.75rem;
    flex-shrink: 0;
    opacity: 0.6;
    margin-left: 0.25rem;
}

.filament-header-select-dropdown {
    position: absolute;
    top: calc(100% + 0.375rem);
    right: 0;
    z-index: 9999;
    width: 12rem;
    max-height: 16rem;
    overflow: auto;
}

.filament-header-select-dropdown-content {
    background: white;
    border: 1px solid rgb(229, 231, 235);
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.dark .filament-header-select-dropdown-content {
    background: rgb(31, 41, 55);
    border-color: rgb(75, 85, 99);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.12);
}

.filament-header-select-list {
    list-style: none;
    margin: 0;
    padding: 0.25rem;
}

.filament-header-select-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    color: rgb(75, 85, 99);
    background-color: transparent;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    text-align: left;
    transition: all 150ms ease-in-out;
}

.filament-header-select-option:hover {
    background-color: rgb(243, 244, 246);
    color: rgb(59, 130, 246);
}

.filament-header-select-option-selected {
    background-color: rgb(59, 130, 246);
    color: white;
    font-weight: 500;
}

.dark .filament-header-select-option {
    color: rgb(209, 213, 219);
}

.dark .filament-header-select-option:hover {
    background-color: rgba(55, 65, 81, 1);
    color: rgb(147, 197, 253);
}

.dark .filament-header-select-option-selected {
    background-color: rgb(59, 130, 246);
    color: white;
}

.filament-header-select-option-text {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.filament-header-select-check-icon {
    height: 1rem;
    width: 1rem;
    flex-shrink: 0;
    margin-left: 0.5rem;
    opacity: 0.9;
}

/* Enhanced animations */
.filament-header-select-nav {
    animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

.filament-header-select-dropdown-content {
    animation: fadeInUp 0.15s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endonce

<div class="filament-header-select">
    <nav class="filament-header-select-nav">
        @foreach ($selects as $index => $select)
            @if ($select->isVisible())
                @php
                    $name = $select->getName();
                    $label = $select->getLabel();
                    $options = $select->getOptions();
                    $placeholder = $select->getPlaceholder();
                    $icon = $select->getIcon();
                    $color = $select->getColor();
                    $rounded = $select->getRounded();
                    $url = $select->getUrl();
                    $newTab = $select->shouldOpenInNewTab();
                    $value = session($name) ?? $select->getDefault();
                    $keepOriginalLabel = $select->shouldKeepOriginalLabel();
                    $refreshable = $select->isRefreshable();
                    
                    // Check if this is a dropdown (has options) or URL link
                    $hasOptions = !empty($options);
                    $hasUrl = !empty($url);
                @endphp
                
                @if ($hasOptions)
                    {{-- Livewire Dropdown Component --}}
                    @livewire('header-select-component', [
                        'selectData' => [
                            'name' => $name,
                            'label' => $label,
                            'options' => $options,
                            'placeholder' => $placeholder,
                            'defaultValue' => $value,
                            'icon' => $icon,
                            'color' => $color,
                            'rounded' => $rounded,
                            'keepOriginalLabel' => $keepOriginalLabel,
                            'refreshable' => $refreshable,
                        ],
                    ], key('header-select-'.$name))
                @elseif ($hasUrl)
                    {{-- URL Link Button --}}
                    <a 
                        href="{{ $url }}" 
                        class="filament-header-select-button {{ $rounded }} {{ $color ? 'color-' . $color : '' }}"
                        @if($newTab) target="_blank" rel="noopener noreferrer" @endif
                    >
                        @if ($icon)
                            <x-filament::icon :icon="$icon" class="fi-icon fi-size-sm" />
                        @endif
                        <span class="truncate">{{ $label }}</span>
                    </a>
                @else
                    {{-- Simple Action Button --}}
                    @livewire('header-select-component', [
                        'selectData' => [
                            'name' => $name,
                            'label' => $label,
                            'icon' => $icon,
                            'color' => $color,
                            'rounded' => $rounded,
                        ],
                        'actionMode' => true,
                    ], key('header-select-action-'.$name))
                @endif
            @endif
        @endforeach
    </nav>
</div>
