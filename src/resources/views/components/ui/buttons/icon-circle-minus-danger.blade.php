<span 
    {{ $attributes->merge(['class' => 'block-inline relative']) }}>
    <svg width="24" height="24" class="svg-absolute-center" >
        <use href="{{ asset('assets/icons/icons.svg#circle-minus-danger') }}"></use>
    </svg>
</span>

<style>
    .svg-absolute-center {
    position: absolute;
    top: 18%;
    right: 11%;

  }
</style>