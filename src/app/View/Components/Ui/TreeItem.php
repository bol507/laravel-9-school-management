<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class TreeItem extends Component
{   
    public string $label;
    public ?string $icon;
    public ?string $href;
    public ?bool $active;
    public ?bool $disabled;
    public ?bool $open;
    public ?bool $hasChildren;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, ?string $icon = null, ?string $href = null, ?bool $active = null, ?bool $disabled = null, ?bool $open = null, ?bool $hasChildren = null)
    {
        $this->label = $label;
        $this->icon = $icon;
        $this->href = $href;
        $this->active = $active;
        $this->disabled = $disabled;
        $this->open = $open;
        $this->hasChildren = $hasChildren;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.tree-item');
    }
}
