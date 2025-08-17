<?php

namespace App\View\Components\Ui;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class DataTable extends Component
{
    public LengthAwarePaginator $items;
    public array $columns;
    public array $actions;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        LengthAwarePaginator $items,
        array $columns =[],
        array $actions = [],
    )
    {
        $this->items = $items;
        $this->columns = $columns;
        $this->actions = $actions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.data-table');
    }
}
