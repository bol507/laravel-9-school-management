@props([
'icon',
'href',
'label'
])
<li
  {{ $attributes->merge(['class' => '']) }}
  x-data=" { isHovered: false } "
  @mouseenter="isHovered = true"
  @mouseleave="isHovered = false"
  @click.prevent="
          open = !open;
          active = open;
          if ($el.closest('[x-data]').accordion && open) {
              $el.closest('[x-data]').collapseAll();
              open = true;
          }else {
            window.location.href = '{{ $href }}'; 
        }
        ">

  <a
    href="{{ $href }}">

    <div class="flex items-center justify-start">
      <svg
        class="more-right"
        aria-hidden="true">
        <use
          :href=" isHovered ? '{{ asset('assets/icons/icons.svg#arrow-right') }}'  : '{{ asset('assets/icons/icons.svg#more') }} ' ">
        </use>
      </svg>
      <span>{{ $label }}</span>
    </div>

  </a>

</li>

<style>
  .more-right {
    margin-left: 0.625rem;
    margin-right: 0.625rem;
    width: 20px;
    height: 20px;
  }
</style>