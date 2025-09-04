<?php

namespace SolutionForest\FilamentHeaderSelect\Livewire;

use Livewire\Component;
use SolutionForest\FilamentHeaderSelect\HeaderSelectPlugin;

class HeaderSelectComponent extends Component
{
    public array $selectData = [];
    public $value = null;
    public bool $actionMode = false;
    public array $currentOptions = [];

    public function mount(array $selectData = [], bool $actionMode = false)
    {
        $this->selectData = $selectData;
        $this->actionMode = $actionMode;
        $this->currentOptions = $selectData['options'] ?? [];
        $name = $this->selectData['name'] ?? '';
        $defaultValue = $this->selectData['defaultValue'] ?? null;
        
        if ($name) {
            $this->value = session($name) ?? $defaultValue;
        }
    }

    public function refreshOptions()
    {
        $name = $this->selectData['name'] ?? '';
        if ($name && ($this->selectData['refreshable'] ?? false)) {
            // Get fresh options from the plugin
            $freshOptions = HeaderSelectPlugin::getFreshOptions($name);
            if ($freshOptions !== null) {
                $this->currentOptions = $freshOptions;
                $this->selectData['options'] = $freshOptions;
            }
        }
    }

    public function selectOption($newValue)
    {
        $this->value = $newValue;
        $this->updatedValue($newValue);
    }

    public function updatedValue($value)
    {
        $name = $this->selectData['name'] ?? '';
        
        if ($name) {
            session([$name => $value]);
            
            // Execute the onChange callback through the plugin
            HeaderSelectPlugin::executeCallback($name, $value);
            
            // Check if there's a redirect URL and dispatch to frontend
            if ($redirectUrl = session('header_select_redirect_url')) {
                session()->forget('header_select_redirect_url');
                $this->dispatch('header-select-redirect', url: $redirectUrl);
                return;
            }
            
            $this->dispatch('header-select-changed', 
                select: $name,
                value: $value
            );
        }
    }

    public function triggerAction()
    {
        $name = $this->selectData['name'] ?? '';
        if ($name) {
            session([$name => $name]);
            HeaderSelectPlugin::executeCallback($name, $name);
            $this->dispatch('header-select-changed', select: $name, value: $name);
        }
    }

    public function render()
    {
        return view('filament-header-select::livewire.header-select-component');
    }
}
