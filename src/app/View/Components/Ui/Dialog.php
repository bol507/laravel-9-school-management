<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Dialog extends Component
{
    public string $id;
    public string $method;
    public ?string $submitText;
    public ?string $title;
    public ?string $message;
    
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id = "modal-confirm",  string $method = 'POST', ?string $submitText = 'Submit', ?string $title = '', ?string $message = '')
    {
        $this->id = $id;
        $this->method = $method;
        $this->submitText = $submitText;
        $this->title = $title;
        $this->message = $message;

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
