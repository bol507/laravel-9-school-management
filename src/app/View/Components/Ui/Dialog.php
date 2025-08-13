<?php

namespace App\View\Components\ui;

use Illuminate\View\Component;

class Dialog extends Component
{
   
    public ?string $method;
    public ?string $submit;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( string $method = 'POST', ?string $submit = 'Submit')
    {
        $this->method = $method;
        $this->submit = $submit;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.dialog');
    }
}
