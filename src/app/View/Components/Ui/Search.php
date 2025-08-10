<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Search extends Component
{
    public string $action;
    public ?string $search;
    
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $action, ?string $search = null)
    {
        $this->action = $action;
        $this->search = $search;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.search');
    }
}
