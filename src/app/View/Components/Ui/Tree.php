<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Tree extends Component
{   
    public bool $accordion;
    /**s
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $accordion = false)
    {
        $this->accordion = $accordion;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.tree');
    }
}
