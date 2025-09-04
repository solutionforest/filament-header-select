@php
    $name = $selectData['name'] ?? '';
    $label = $selectData['label'] ?? null;
    $options = $selectData['options'] ?? [];
    $placeholder = $selectData['placeholder'] ?? null;
    $icon = $selectData['icon'] ?? null;
@endphp
<div>
@if ($actionMode)
    <button type="button" wire:click="triggerAction" class="filament-header-select-button">
        @if ($icon)
            <x-filament::icon :icon="$icon" class="fi-icon fi-size-sm" />
        @endif
        <span class="truncate">{{ $label }}</span>
    </button>
@else
    <div class="relative" x-data="{open: false}" @click.outside="open = false">
        <button type="button" class="filament-header-select-button {{ ($value!==null && $value!=='') ? 'filament-header-select-button-active' : '' }}" @click="open = !open" style="gap:0.75rem">
            @if ($icon)
                <x-filament::icon :icon="$icon" class="fi-icon fi-size-sm" />
            @endif
            <span class="truncate">{{ $options[$value] ?? $placeholder ?? $label }}</span>
            <svg class="filament-header-select-icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
            </svg>
        </button>
        <div x-show="open" 
             class="filament-header-select-dropdown" >
            <div class="filament-header-select-dropdown-content">
                <ul class="filament-header-select-list">
                    @if ($placeholder)
                        <li>
                            <button type="button" wire:click="selectOption('')" class="filament-header-select-option {{ $value === null || $value==='' ? 'filament-header-select-option-selected cursor-default' : '' }}">
                                <span class="filament-header-select-option-text">{{ $placeholder }}</span>
                            </button>
                        </li>
                    @endif
            @php $urls = $selectData['optionUrls'] ?? []; @endphp
            @foreach ($options as $optionValue => $optionLabel)
                        <li>
                @php $hasUrl = isset($urls[$optionValue]) && $urls[$optionValue]; @endphp
                <button type="button" wire:click="selectOption('{{ $optionValue }}')" class="filament-header-select-option {{ (string)$value === (string)$optionValue ? 'filament-header-select-option-selected cursor-default' : '' }} {{ $hasUrl ? 'has-url' : '' }}">
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