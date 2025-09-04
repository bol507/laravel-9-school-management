<span class="pull-right-container">
  <svg class="angle-right" >
    <use href="{{ asset('assets/icons/icons.svg#angle-right') }}"></use>
  </svg>
</span>

<style>
  .pull-right-container {
    position: absolute;
    right: 10px;
    top: 50%;
    margin-top: -0.25rem
  }

  .pull-right-container>svg {
    width: 24px;
    height: 24px;
    padding: 0;
    margin-right: 10px;
    transition: transform .5s ease;
  }

  .angle-right {
    position: absolute;
    top: 50%;
    right: 0;
    margin-top: -8px;
  }

  .sidebar-menu .menu-open > a > .angle-right,
  .sidebar-menu .menu-open > a > .pull-right-container > .angle-right,
  .sidebar-menu .menu-open > a > .pull-right-container > svg {
      transform: rotate(90deg);
  }
</style>

