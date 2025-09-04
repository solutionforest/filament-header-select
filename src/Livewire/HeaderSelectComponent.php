<?php

namespace SolutionForest\FilamentHeaderSelect\Livewire;

use Livewire\Component;
use SolutionForest\FilamentHeaderSelect\HeaderSelectPlugin;

class HeaderSelectComponent extends Component
{
    public array $selectData = [];
    public $value = null;
    public bool $actionMode = false; // when true, acts as simple action button

    public function mount(array $selectData = [], bool $actionMode = false)
    {
        $this->selectData = $selectData;
        $this->actionMode = $actionMode;
        $name = $this->selectData['name'] ?? '';
        $defaultValue = $this->selectData['defaultValue'] ?? null;
        
        if ($name) {
            $this->value = session($name) ?? $defaultValue;
        }
    }

    public function updatedValue($value)
    {
        $name = $this->selectData['name'] ?? '';
        
        if ($name) {
            session([$name => $value]);
            
            // Execute the onChange callback through the plugin
            HeaderSelectPlugin::executeCallback($name, $value);
            
            $this->dispatch('header-select-changed', 
                select: $name,
                value: $value
            );
        }
    }

    public function triggerAction()
    {
        // Simple action: set session value to its name (toggle semantics can be implemented via callback)
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
