@props([
'label',
'icon' => null,
'href' => '#',
])

<li
  {{ $attributes->merge(['class' => '']) }}
  x-data="{ open: false, active: false }"
  :class="{ 'menu-open': active }"
>


  @if($slot->isNotEmpty())
    
      <x-ui.buttons.icon-with-slot 
        icon="{{ $icon }}" 
        href="{{ $href }}"
        @click.prevent="
          open = !open;
          active = open;
          if ($el.closest('[x-data]').accordion && open) {
              $el.closest('[x-data]').collapseAll();
              open = true;
          }
        "
      >
          <span>{{ $label }}</span>
          <x-ui.buttons.angle-right />
      </x-ui.buttons.icon-with-slot>
   
    <ul x-show="open" x-ref="menu" x-transition class="treeview-menu">
      {{ $slot }}
    </ul>
  @else
    <x-ui.buttons.icon-with-slot
      icon="{{ $icon }}" 
      href="{{ $href }}"
      @click.prevent="
                active = true;
                $dispatch('reset-active');
            "
    >
      {{ $label }}
    </x-ui.buttons.icon-with-slot>
  @endif
</li>