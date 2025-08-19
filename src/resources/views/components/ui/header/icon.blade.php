@props([
'icon' => '',
'href' => '#',
'title' => '',
])
<a 
    href="{{ $href }}" 
    title="{{ $title }}"
    class="waves-effect nav-link rounded bt-icon nav-link-icon" 
    data-toggle="push-menu" 
    role="button">
    <svg
        width="24"
        height="24">
        <use
            xlink:href="{{ asset('assets/icons/icons.svg#' . $icon) }}">
        </use>
    </svg>
</a>