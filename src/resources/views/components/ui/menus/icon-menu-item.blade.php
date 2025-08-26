@props([
'icon',
'href',
'label'
])
<li
  {{ $attributes->merge(['class' => '']) }}
  x-data="{ open: false, active: false }"
  :class="{ 'menu-open': active }">

  <x-ui.buttons.icon-with-slot
    icon="{{ $icon }}"
    href="{{ $href }}"
    @click.prevent="
            open = !open;
            active = open;
            if ($el.closest('[x-data]').accordion && open) {
                $el.closest('[x-data]').collapseAll();
                open = true;
            } else {
              window.location.href = '{{ $href }}'; 
              }

        ">
    <span>{{ $label }}</span>
    @if ($slot->isNotEmpty())
    <x-ui.buttons.angle-right />
    @endif
  </x-ui.buttons.icon-with-slot>

  @if ($slot->isNotEmpty())
  <ul x-show="open" x-ref="menu" x-transition class="treeview-menu">
    {{ $slot }}
  </ul>
  @endif
</li>