@props([
'icon',
'href',
'label'
])
<li
  {{ $attributes->merge(['class' => '']) }}
  x-data="{ active: window.location.href === '{{ rtrim($href, '#') }}' }"
  :class="{ 'active': active }"
  @click.prevent="
       window.location.href = '{{ $href }}';
  "
>

  <a
    href="{{ $href }}">

    <div class="flex items-center justify-start">
      <svg
        class="more-right"
        aria-hidden="true">
        <use
          :href=" active ? '{{ asset('assets/icons/icons.svg#arrow-right') }}'  : '{{ asset('assets/icons/icons.svg#more') }} ' ">
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