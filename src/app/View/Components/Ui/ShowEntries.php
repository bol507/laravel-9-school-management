<?php

namespace App\View\Components\Ui;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class ShowEntries extends Component
{
    
    public LengthAwarePaginator $docs;
    public string $action;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(LengthAwarePaginator $docs, string $action)
    {
        $this->action = $action;
        $this->docs = $docs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.show-entries');
    }
}
