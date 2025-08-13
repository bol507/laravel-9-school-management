<?php

namespace App\View\Components\Ui;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Paginator extends Component
{
    
    public LengthAwarePaginator $docs;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(LengthAwarePaginator $docs)
    {
        $this->docs = $docs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.paginator');
    }
}
