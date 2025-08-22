@props([
    'icon'  => null,
    'href'  => '#',
    'title' => null,
])
<a 
    href="{{ $href }}" 
    title="{{ $title }}"
    aria-label="{{ $title }}"
    {{ $attributes->merge(['class' => ' ']) }}>
    @if ($icon)
        <svg>
            <use xlink:href="{{ asset('assets/icons/icons.svg#' . $icon) }}"></use>
        </svg>
    @endif

    
    {{ $slot }}
    

    
</a>