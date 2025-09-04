<?php

namespace SolutionForest\FilamentHeaderSelect\Components;

use Closure;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Concerns\HasExtraAttributes;
use Illuminate\Contracts\Support\Htmlable;

class HeaderSelect implements Htmlable
{
    use EvaluatesClosures;
    use HasExtraAttributes;

    protected string $name;
    protected string | Closure | null $label = null;
    protected array | Closure $options = [];
    protected mixed $default = null;
    protected string | Closure | null $placeholder = null;
    protected bool | Closure $visible = true;
    protected bool | Closure $disabled = false;
    protected Closure | null $onChange = null;
    protected string | null $icon = null;
    protected string | null $color = null;
    protected string | Closure | null $url = null;
    protected bool $newTab = false;
    protected string $rounded = 'rounded-full'; // 'rounded-none', 'rounded', 'rounded-lg', 'rounded-full'
    protected bool $keepOriginalLabel = true; // Keep original label instead of showing selected value
    protected bool $refreshable = false; // Allow dynamic option updates

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function label(string | Closure | null $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function options(array | Closure $options): static
    {
        $this->options = $options;
        return $this;
    }

    public function default(mixed $default): static
    {
        $this->default = $default;
        return $this;
    }

    public function placeholder(string | Closure | null $placeholder): static
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function visible(bool | Closure $visible = true): static
    {
        $this->visible = $visible;
        return $this;
    }

    public function disabled(bool | Closure $disabled = true): static
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function onChange(Closure $callback): static
    {
        $this->onChange = $callback;
        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function url(string | Closure $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function newTab(bool $newTab = true): static
    {
        $this->newTab = $newTab;
        return $this;
    }

    public function rounded(string $rounded = 'rounded-full'): static
    {
        $this->rounded = $rounded;
        return $this;
    }

    public function keepOriginalLabel(bool $keep = true): static
    {
        $this->keepOriginalLabel = $keep;
        return $this;
    }

    public function refreshable(bool $refreshable = true): static
    {
        $this->refreshable = $refreshable;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): ?string
    {
        return $this->evaluate($this->label);
    }

    public function getOptions(): array
    {
        $options = $this->evaluate($this->options);
        return is_array($options) ? $options : [];
    }

    public function getDefault(): mixed
    {
        return $this->evaluate($this->default);
    }

    public function getPlaceholder(): ?string
    {
        return $this->evaluate($this->placeholder);
    }

    public function isVisible(): bool
    {
        $result = $this->evaluate($this->visible);
        return is_bool($result) ? $result : true;
    }

    public function isDisabled(): bool
    {
        $result = $this->evaluate($this->disabled);
        return is_bool($result) ? $result : false;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getRounded(): string
    {
        return $this->rounded;
    }

    public function getOnChange(): ?\Closure
    {
        return $this->onChange;
    }

    public function getUrl(): ?string
    {
        return $this->evaluate($this->url);
    }

    public function shouldOpenInNewTab(): bool
    {
        return $this->newTab;
    }

    public function shouldKeepOriginalLabel(): bool
    {
        return $this->keepOriginalLabel;
    }

    public function isRefreshable(): bool
    {
        return $this->refreshable;
    }

    public function handleChange(mixed $value): void
    {
        if ($this->onChange) {
            ($this->onChange)($value);
        }
    }

    public function toHtml(): string
    {
        return '';
    }
}
