@php
    $name = $selectData['name'] ?? '';
    $label = $selectData['label'] ?? null;
    $options = $currentOptions ?? $selectData['options'] ?? [];
    $placeholder = $selectData['placeholder'] ?? null;
    $icon = $selectData['icon'] ?? null;
    $color = $selectData['color'] ?? null;
    $rounded = $selectData['rounded'] ?? 'rounded';
    $redirectUrl = $selectData['redirectUrl'] ?? null;
    $keepOriginalLabel = $selectData['keepOriginalLabel'] ?? false;
    $refreshable = $selectData['refreshable'] ?? false;
@endphp

<div x-data="{ 
    init() {
        Livewire.on('header-select-redirect', (event) => {
            window.location.href = event.url;
        });
    }
}">
@if ($actionMode)
    <button type="button" wire:click="triggerAction" class="filament-header-select-button {{ $rounded }} {{ $color ? 'color-' . $color : '' }}">
        @if ($icon)
            <x-filament::icon :icon="$icon" class="fi-icon fi-size-sm" />
        @endif
        <span class="truncate">{{ $label }}</span>
    </button>
@else
    <div class="relative" x-data="{open: false}" @click.outside="open = false">
        <div class="flex items-center">
            <button type="button" 
                    class="filament-header-select-button {{ $rounded }} {{ $color ? 'color-' . $color : '' }}" 
                    @click="open = !open">
                @if ($icon)
                    <x-filament::icon :icon="$icon" class="fi-icon fi-size-sm" />
                @endif
                <span class="truncate">
                    @if ($keepOriginalLabel)
                        {{ $label }}
                    @else
                        {{ $options[$value] ?? $placeholder ?? $label }}
                    @endif
                </span>
                <svg class="filament-header-select-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                </svg>
            </button>
            
            @if ($refreshable)
                <button type="button" 
                        wire:click="refreshOptions" 
                        class="ml-1 p-0.5 rounded hover:bg-gray-200 dark:hover:bg-gray-600 opacity-60 hover:opacity-100"
                        title="Refresh options">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            @endif
        </div>
        
        <div x-show="open" class="filament-header-select-dropdown">
            <div class="filament-header-select-dropdown-content">
                <ul class="filament-header-select-list">
                    @if ($placeholder)
                        <li>
                            <button type="button" 
                                    wire:click="selectOption('')" 
                                    class="filament-header-select-option {{ $value === null || $value==='' ? 'filament-header-select-option-selected' : '' }}">
                                <span class="filament-header-select-option-text">{{ $placeholder }}</span>
                            </button>
                        </li>
                    @endif
                    
                    @foreach ($options as $optionValue => $optionLabel)
                        <li>
                            <button type="button" 
                                    wire:click="selectOption('{{ $optionValue }}')" 
                                    class="filament-header-select-option {{ (string)$value === (string)$optionValue ? 'filament-header-select-option-selected' : '' }}">
                                <span class="filament-header-select-option-text">{{ $optionLabel }}</span>
                                @if ((string)$value === (string)$optionValue)
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
@endif
</div>