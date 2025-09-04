@once
<style>
/* Alpine.js x-cloak directive */
[x-cloak] { display: none !important; }

/* Filament Header Select - Theme Variables */
:root {
    --fhs-nav-bg: white;
    --fhs-nav-border: rgb(229 231 235);
    --fhs-nav-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --fhs-button-text: rgb(75 85 99);
    --fhs-button-hover-bg: rgb(249 250 251);
    --fhs-button-hover-text: rgb(31 41 55);
    --fhs-dropdown-bg: white;
    --fhs-dropdown-border: rgb(229 231 235);
    --fhs-dropdown-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.1);
    --fhs-option-text: rgb(75 85 99);
    --fhs-option-hover-bg: rgb(249 250 251);
    --fhs-option-hover-text: rgb(31 41 55);
    --fhs-selected-bg: rgb(59 130 246);
    --fhs-selected-text: white;
    --fhs-selected-hover-bg: rgb(37 99 235);
}

.dark {
    --fhs-nav-bg: rgb(17 24 39);
    --fhs-nav-border: rgb(75 85 99);
    --fhs-button-text: rgb(209 213 219);
    --fhs-button-hover-bg: rgb(55 65 81);
    --fhs-button-hover-text: white;
    --fhs-dropdown-bg: rgb(17 24 39);
    --fhs-dropdown-border: rgb(75 85 99);
    --fhs-option-text: rgb(209 213 219);
    --fhs-option-hover-bg: rgb(55 65 81);
    --fhs-option-hover-text: white;
}

/* Filament Header Select - Clean Modern Styles */
.filament-header-select {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    z-index: 50;
    display: none;
    overflow: visible !important; /* Allow dropdown to extend outside container */
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
    padding: 0.375rem;
    background-color: var(--fhs-nav-bg);
    border: 1px solid var(--fhs-nav-border);
    border-radius: 0.75rem;
    box-shadow: var(--fhs-nav-shadow);
    overflow: visible !important; /* Allow dropdown to extend outside nav */
}

.dark .filament-header-select-nav {
    background-color: var(--fhs-nav-bg);
    border-color: var(--fhs-nav-border);
}

.filament-header-select-button {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.25rem;
    color: var(--fhs-button-text);
    background-color: transparent;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    text-decoration: none;
    transition: all 150ms ease-in-out;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 12rem;
}

.filament-header-select-button:hover {
    background-color: var(--fhs-button-hover-bg);
    color: var(--fhs-button-hover-text);
}

.filament-header-select-button:focus {
    outline: none;
    background-color: var(--fhs-button-hover-bg);
}

.dark .filament-header-select-button {
    color: var(--fhs-button-text);
}

.dark .filament-header-select-button:hover {
    background-color: var(--fhs-button-hover-bg);
    color: var(--fhs-button-hover-text);
}

.dark .filament-header-select-button:focus {
    background-color: var(--fhs-button-hover-bg);
}

.filament-header-select-button-active {
    background-color: rgb(59 130 246) !important;
    color: white !important;
}

.dark .filament-header-select-button-active {
    background-color: rgb(59 130 246) !important;
    color: white !important;
}

.filament-header-select-icon {
    height: 1rem;
    width: 1rem;
    flex-shrink: 0;
    opacity: 0.7;
}

.filament-header-select-button .fi-icon {
    height: 1rem;
    width: 1rem;
    flex-shrink: 0;
}

/* Color variants */
.filament-header-select-button-primary {
    background-color: rgb(59 130 246) !important;
    color: white !important;
}

.filament-header-select-button-primary:hover {
    background-color: rgb(37 99 235) !important;
}

.filament-header-select-button-success {
    background-color: rgb(34 197 94) !important;
    color: white !important;
}

.filament-header-select-button-success:hover {
    background-color: rgb(22 163 74) !important;
}

.filament-header-select-button-warning {
    background-color: rgb(245 158 11) !important;
    color: white !important;
}

.filament-header-select-button-warning:hover {
    background-color: rgb(217 119 6) !important;
}

.filament-header-select-button-danger {
    background-color: rgb(239 68 68) !important;
    color: white !important;
}

.filament-header-select-button-danger:hover {
    background-color: rgb(220 38 38) !important;
}

.filament-header-select-dropdown {
    position: absolute;
    top: calc(100% + 0.1rem);
    z-index: 9999;
    width: 14rem;
    max-height: 20rem;
    overflow: auto;
}

.filament-header-select-dropdown-content {
    background-color: var(--fhs-dropdown-bg);
    border: 1px solid var(--fhs-dropdown-border);
    border-radius: 0.75rem;
    box-shadow: var(--fhs-dropdown-shadow);
    overflow: hidden;
}

.dark .filament-header-select-dropdown-content {
    background-color: var(--fhs-dropdown-bg);
    border-color: var(--fhs-dropdown-border);
}

.filament-header-select-list {
    list-style: none;
    margin: 0;
    padding: 0.25rem;
}

.filament-header-select-list > li {
    margin: 0;
}

.filament-header-select-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: var(--fhs-option-text);
    background-color: transparent;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    text-align: left;
    transition: background-color 150ms ease-in-out;
}

.filament-header-select-option:hover {
    background-color: var(--fhs-option-hover-bg);
    color: var(--fhs-option-hover-text);
}

.filament-header-select-option:focus {
    outline: none;
    background-color: var(--fhs-option-hover-bg);
}

.dark .filament-header-select-option {
    color: var(--fhs-option-text);
}

.dark .filament-header-select-option:hover {
    background-color: var(--fhs-option-hover-bg);
    color: var(--fhs-option-hover-text);
}

.dark .filament-header-select-option:focus {
    background-color: var(--fhs-option-hover-bg);
}

.filament-header-select-option-selected {
    background-color: var(--fhs-selected-bg);
    color: var(--fhs-selected-text);
}

.filament-header-select-option-selected:hover {
    background-color: var(--fhs-selected-hover-bg);
}

/* Prevent hover flicker & indicate non-clickable selected */
.filament-header-select-option-selected.cursor-default {
    pointer-events: none;
}

/* Active trigger button subtle ring */
.filament-header-select-button-active {
    box-shadow: 0 0 0 1px rgba(59,130,246,.4), 0 0 0 3px rgba(59,130,246,.15);
}

.dark .filament-header-select-option-selected {
    background-color: var(--fhs-selected-bg);
    color: var(--fhs-selected-text);
}

.dark .filament-header-select-option-selected:hover {
    background-color: var(--fhs-selected-hover-bg);
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
    opacity: 0.8;
}

/* Indicate navigable option */
.filament-header-select-option.has-url:not(.filament-header-select-option-selected) {
    position: relative;
}
.filament-header-select-option.has-url:not(.filament-header-select-option-selected)::after {
    content: '\2192'; /* arrow */
    font-size: 0.75rem;
    opacity: .45;
    margin-left: .5rem;
}
.filament-header-select-option.has-url:hover::after {
    opacity: .8;
}

/* ------------------------------------------------------------------ */
/* Visual refinement: lighter active + selected states (override)      */
/* ------------------------------------------------------------------ */

/* Active trigger button (value selected or open) */
.filament-header-select-button-active {
    background-color: rgba(59,130,246,0.12) !important;
    color: var(--fhs-button-text) !important;
    border: 1px solid rgba(59,130,246,0.35) !important;
    box-shadow: 0 1px 2px 0 rgba(0,0,0,0.04);
}

.filament-header-select-button-active:hover,
.filament-header-select-button-active:focus {
    background-color: rgba(59,130,246,0.18) !important;
}

/* Selected option in dropdown */
.filament-header-select-option-selected {
    background-color: rgba(59,130,246,0.15) !important;
    color: var(--fhs-button-text) !important;
    font-weight: 500;
}

.filament-header-select-option-selected:hover,
.filament-header-select-option-selected:focus {
    background-color: rgba(59,130,246,0.22) !important;
}

/* Check icon color & subtle emphasis */
.filament-header-select-option-selected .filament-header-select-check-icon {
    color: rgb(59 130 246);
    opacity: 0.95;
}

/* Dark mode adjustments */
.dark .filament-header-select-button-active {
    background-color: rgba(59,130,246,0.22) !important;
    color: var(--fhs-button-text) !important;
    border-color: rgba(59,130,246,0.55) !important;
}

.dark .filament-header-select-option-selected {
    background-color: rgba(59,130,246,0.25) !important;
    color: var(--fhs-option-text) !important;
}

.dark .filament-header-select-option-selected:hover,
.dark .filament-header-select-option-selected:focus {
    background-color: rgba(59,130,246,0.35) !important;
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
                    $disabled = $select->isDisabled();
                    $icon = $select->getIcon();
                    $iconClass = $select->getIconClass();
                    $iconSpacing = $select->getIconSpacing();
                    $colorClass = $select->getColorClass();
                    $url = $select->getUrl();
                    $newTab = $select->shouldOpenInNewTab();
                    $selectId = "header-select-{$name}";
                    $value = session($name) ?? $select->getDefault();
                    $selectedLabel = $placeholder;
                    
                    // Find the selected option label
                    foreach ($options as $optionValue => $optionLabel) {
                        if ($value == $optionValue) {
                            $selectedLabel = $optionLabel;
                            break;
                        }
                    }
                    
                    if (!$selectedLabel && $placeholder) {
                        $selectedLabel = $placeholder;
                    }
                    
                    // Check if this is a dropdown (has options), URL link, or simple button
                    $hasOptions = !empty($options);
                    $hasUrl = !empty($url);
                    $isActive = $value && $value !== '';
                    
                    // For URL links, check if current URL matches
                    if ($hasUrl && !$hasOptions) {
                        $currentUrl = request()->url();
                        $isActive = $currentUrl === $url || request()->routeIs($name);
                    }
                @endphp
                
                @if ($hasOptions)
                    {{-- Livewire Dropdown Component (stateful, no extra route/middleware) --}}
                    @livewire('header-select-component', [
                        'selectData' => [
                            'name' => $name,
                            'label' => $label,
                            'options' => $options,
                            'placeholder' => $placeholder,
                            'defaultValue' => $value,
                            'icon' => $icon,
                        ],
                    ], key('header-select-'.$name))
                @elseif ($hasUrl)
                    {{-- URL Link Button --}}
                    <a 
                        href="{{ $url }}" 
                        title="{{ $label }}" 
                        class="filament-header-select-button {{ $isActive ? 'filament-header-select-button-active' : '' }} {{ $colorClass }}"
                        style="gap: {{ $iconSpacing }}"
                        @if($newTab) target="_blank" rel="noopener noreferrer" @endif
                    >
                        @if ($icon)
                            <x-filament::icon :icon="$icon" class="{{ $iconClass }}" />
                        @endif
                        <span class="truncate">{{ $label }}</span>
                    </a>
                @else
                    {{-- Simple Action via Livewire --}}
                    @livewire('header-select-component', [
                        'selectData' => [
                            'name' => $name,
                            'label' => $label,
                            'placeholder' => $label,
                            'defaultValue' => $value,
                            'icon' => $icon,
                        ],
                        'actionMode' => true,
                    ], key('header-select-action-'.$name))
                @endif
            @endif
        @endforeach
    </nav>
</div>
