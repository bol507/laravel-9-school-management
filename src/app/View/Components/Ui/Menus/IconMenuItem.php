<?php


namespace App\View\Components\Ui\Menus;
use Illuminate\View\View;
use Illuminate\View\Component;

class IconMenuItem extends Component {
  public string $icon;
  public ?string $href;
  public ?string $label;

  public function __construct(string $icon, ?string $href = '#', ?string $label = null) {
    $this->icon = $icon;
    $this->href = $href;
    $this->label = $label;
  }

  public function render(): View {
    return view('components.ui.menus.icon-menu-item');
  }
}