@once
<style>
/* Filament Header Select Custom Styles */
.filament-header-select {
    position: fixed;
    top: 0.5rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 70;
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
    border-radius: 9999px;
    padding: 0.125rem;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    background-color: rgb(241 245 249);
    border: 1px solid rgb(226 232 240);
}

.dark .filament-header-select-nav {
    background-color: rgb(255 255 255 / 0.05);
    border-color: rgb(255 255 255 / 0.1);
}

.filament-header-select-button {
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    color: rgb(71 85 105);
    background-color: transparent;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    gap: 0.75rem; /* Increased icon spacing using gap */
    white-space: nowrap;
    max-width: 200px; /* Limit button width */
    overflow: hidden;
    text-overflow: ellipsis;
}

.filament-header-select-button:hover {
    color: rgb(15 23 42);
    background-color: rgb(226 232 240);
}

.dark .filament-header-select-button {
    color: rgb(255 255 255 / 0.7);
}

.dark .filament-header-select-button:hover {
    color: rgb(255 255 255);
    background-color: rgb(255 255 255 / 0.1);
}

.filament-header-select-button-active {
    background-color: rgb(15 23 42) !important;
    color: rgb(255 255 255) !important;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
}

.dark .filament-header-select-button-active {
    background-color: rgb(255 255 255) !important;
    color: rgb(15 23 42) !important;
}

.filament-header-select-icon {
    margin-left: 0.25rem;
    display: inline-block;
    height: 1rem;
    width: 1rem;
    opacity: 0.8;
}

/* Ensure Filament icons have proper spacing in our buttons */
.filament-header-select-button .fi-icon {
    flex-shrink: 0;
    margin: 0;
}

.filament-header-select-dropdown {

.filament-header-select-dropdown {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    margin-top: 0.5rem;
    z-index: 80;
    width: 15rem;
}

.filament-header-select-dropdown-content {
    width: 100%;
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.05);
    border: 1px solid rgb(226 232 240);
    background-color: rgb(255 255 255);
}

.dark .filament-header-select-dropdown-content {
    border-color: rgb(255 255 255 / 0.1);
    background-color: rgb(39 39 42);
}

.filament-header-select-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.filament-header-select-list > li {
    border-bottom: 1px solid rgb(241 245 249);
}

.dark .filament-header-select-list > li {
    border-bottom-color: rgb(255 255 255 / 0.05);
}

.filament-header-select-list > li:last-child {
    border-bottom: none;
}

.filament-header-select-option {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    color: rgb(51 65 85);
    background-color: transparent;
    border: none;
    cursor: pointer;
    text-align: left;
    transition: background-color 0.15s ease-in-out;
}

.filament-header-select-option:hover {
    background-color: rgb(248 250 252);
}

.dark .filament-header-select-option {
    color: rgb(244 244 245);
}

.dark .filament-header-select-option:hover {
    background-color: rgb(255 255 255 / 0.1);
}

.filament-header-select-option-selected {
    background-color: rgb(248 250 252);
}

.dark .filament-header-select-option-selected {
    background-color: rgb(255 255 255 / 0.1);
}

.filament-header-select-option-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.filament-header-select-check-icon {
    height: 1rem;
    width: 1rem;
    opacity: 0.3;
    flex-shrink: 0;
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
                    {{-- Dropdown Select --}}
                    <div class="relative" x-data="{ open_{{ $index }}: false }" @click.outside="open_{{ $index }} = false">
                        <button 
                            type="button" 
                            @click="open_{{ $index }} = !open_{{ $index }}" 
                            aria-haspopup="listbox" 
                            :aria-expanded="open_{{ $index }}" 
                            title="{{ $label }}" 
                            class="filament-header-select-button {{ $isActive ? 'filament-header-select-button-active' : '' }}"
                            style="gap: {{ $iconSpacing }}"
                        >
                            @if ($icon)
                                <x-filament::icon :icon="$icon" class="{{ $iconClass }}" />
                            @endif
                            <span class="truncate">{{ $selectedLabel }}</span>
                            <svg class="filament-header-select-icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div 
                            x-show="open_{{ $index }}" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="filament-header-select-dropdown" 
                            style="display: none;"
                        >
                            <div class="filament-header-select-dropdown-content">
                                <ul role="listbox" class="filament-header-select-list">
                                    @if ($placeholder)
                                        <li>
                                            <button 
                                                type="button"
                                                @click="
                                                    fetch('/filament-header-select/update', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                                        },
                                                        body: JSON.stringify({
                                                            name: '{{ $name }}',
                                                            value: ''
                                                        })
                                                    });
                                                    open_{{ $index }} = false;
                                                    location.reload();
                                                "
                                                class="filament-header-select-option {{ !$value ? 'filament-header-select-option-selected' : '' }}"
                                            >
                                                <span class="filament-header-select-option-text">{{ $placeholder }}</span>
                                                @if (!$value)
                                                    <svg class="filament-header-select-check-icon" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </li>
                                    @endif
                                    
                                    @foreach ($options as $optionValue => $optionLabel)
                                        <li>
                                            <button 
                                                type="button"
                                                @click="
                                                    fetch('/filament-header-select/update', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                                        },
                                                        body: JSON.stringify({
                                                            name: '{{ $name }}',
                                                            value: '{{ $optionValue }}'
                                                        })
                                                    });
                                                    open_{{ $index }} = false;
                                                    location.reload();
                                                "
                                                class="filament-header-select-option {{ $value == $optionValue ? 'filament-header-select-option-selected' : '' }}"
                                            >
                                                <span class="filament-header-select-option-text">{{ $optionLabel }}</span>
                                                @if ($value == $optionValue)
                                                    <svg class="filament-header-select-check-icon" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @elseif ($hasUrl)
                    {{-- URL Link Button --}}
                    <a 
                        href="{{ $url }}" 
                        title="{{ $label }}" 
                        class="filament-header-select-button {{ $isActive ? 'filament-header-select-button-active' : '' }}"
                        style="gap: {{ $iconSpacing }}"
                        @if($newTab) target="_blank" rel="noopener noreferrer" @endif
                    >
                        @if ($icon)
                            <x-filament::icon :icon="$icon" class="{{ $iconClass }}" />
                        @endif
                        <span class="truncate">{{ $label }}</span>
                    </a>
                @else
                    {{-- Simple Button/Action --}}
                    <button 
                        type="button" 
                        title="{{ $label }}" 
                        class="filament-header-select-button {{ $isActive ? 'filament-header-select-button-active' : '' }}"
                        style="gap: {{ $iconSpacing }}"
                        @click="
                            fetch('/filament-header-select/update', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                },
                                body: JSON.stringify({
                                    name: '{{ $name }}',
                                    value: '{{ $name }}'
                                })
                            });
                            location.reload();
                        "
                    >
                        @if ($icon)
                            <x-filament::icon :icon="$icon" class="{{ $iconClass }}" />
                        @endif
                        <span class="truncate">{{ $label }}</span>
                    </button>
                @endif
            @endif
        @endforeach
    </nav>
</div>
