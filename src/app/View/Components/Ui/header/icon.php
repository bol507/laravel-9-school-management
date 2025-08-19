<?php

namespace App\View\Components\ui\header;

use Illuminate\View\Component;

class icon extends Component
{   
    public string $icon;
    public ?string $href;
    public ?string $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $icon, ?string $href = '#', ?string $title = null)
    {
        $this->icon = $icon;
        $this->href = $href;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.header.icon');
    }
}
