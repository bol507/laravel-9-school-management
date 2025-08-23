<div class="flex items-center justify-start">
    <svg
        {{ $attributes->merge(['class' => 'more-right']) }}
        x-data=" { isHovered: false } "
        @mouseenter="isHovered = true"
        @mouseleave="isHovered = false"
        aria-hidden="true">
        <use
            :href=" isHovered ? '{{ asset('assets/icons/icons.svg#arrow-right') }}'  : '{{ asset('assets/icons/icons.svg#more') }} ' ">
        </use>
    </svg>
    <span>{{ $slot}}</span>
</div>

<style>
    .more-right {
        margin-left: 0.625rem;
        margin-right: 0.625rem;
        width: 20px;
        height: 20px;
    }
</style>