
    <svg
        {{ $attributes->merge(['class' => 'more-right']) }}
        x-data="{ isHovered: false }"
        @mouseenter="isHovered = true"
        @mouseleave="isHovered = false">
        <use
            :xlink:href="isHovered 
            ? '{{ asset('assets/icons/icons.svg#arrow-right') }}' 
            : '{{ asset('assets/icons/icons.svg#more') }}'">
        </use>
    </svg>


<style>
    .more-right {
        width: 24px;
        height: 24px;
        padding: 0;
        margin-right: 10px;
        transition: transform .5s ease;
    }

    .more-right:hover {
        transform: translateX(4px);
    }
</style>