@props([
    'icon'  => null,
    'href'  => '#',
    'title' => null,
])
<a 
    href="{{ $href }}" 
    title="{{ $title }}"
    aria-label="{{ $title }}"
    {{ $attributes->merge(['class' => ' waves-effect nav-link rounded bt-icon nav-link-icon']) }}>
    @if ($icon)
        <svg width="24" height="24">
            <use xlink:href="{{ asset('assets/icons/icons.svg#' . $icon) }}"></use>
        </svg>
    @endif

    

    
</a>