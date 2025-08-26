<?php

namespace App\View\Components\Ui\Menus;

use Illuminate\View\View;
use Illuminate\View\Component;

class IconSubMenuItem extends Component {
  public ?string $href;
  public ?string $label;

  public function __construct( ?string $href = '#', ?string $label = null) {
    $this->href = $href;
    $this->label = $label;
    
  }

  public function render(): View {
    return view('components.ui.menus.icon-sub-menu-item');
  }
}