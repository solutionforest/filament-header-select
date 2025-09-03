@php
    $name = $selectData['name'] ?? '';
    $label = $selectData['label'] ?? null;
    $options = $selectData['options'] ?? [];
    $placeholder = $selectData['placeholder'] ?? null;
    $disabled = $selectData['disabled'] ?? false;
    $icon = $selectData['icon'] ?? null;
    $selectId = "header-select-{$name}";
@endphp

<div class="filament-header-select">
    <div class="relative">
        @if ($label)
            <label for="{{ $selectId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                @if ($icon)
                    <x-filament::icon :icon="$icon" class="h-4 w-4 inline mr-1" />
                @endif
                {{ $label }}
            </label>
        @endif
        
        <select
            id="{{ $selectId }}"
            wire:model.live="value"
            @disabled($disabled)
            class="
                w-full rounded-lg border-gray-300 dark:border-gray-600
                bg-white dark:bg-gray-800 shadow-sm text-sm
                focus:border-primary-500 focus:ring-primary-500
                disabled:cursor-not-allowed disabled:bg-gray-50 dark:disabled:bg-gray-900
                {{ config('filament-header-select.default_classes') }}
            "
        >
            @if ($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
            @endforeach
        </select>
    </div>
</div>
