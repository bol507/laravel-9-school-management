@php 
  $prefix = Request::route()->getPrefix();
  $route = Route::current()->getName();
@endphp
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar-->
  <section class="sidebar">

    <div class="user-profile">
      <div class="ulogo">
        <a href="{{ route('dashboard') }}">
          <!-- logo for regular state and mobile devices -->
          <div class="flex align-center justify-center">
            <img src="{{asset('backend/images/logo-dark.png')}}" alt="logo">
            <h3><b>School</b> admin</h3>
          </div>
        </a>
      </div>
    </div>

    <!-- sidebar menu-->
    <x-ui.tree  >
      <x-ui.menus.icon-menu-item icon="pie-chart" label="Dashboard"  href="{{ route('dashboard') }}" class="{{ ($route == 'dashboard') ? 'active' : '' }}" />
      
      <x-ui.menus.icon-menu-item icon="message-circle" label="Manage user"  href="#" class="treeview {{  ($prefix == '/users') ? 'active' : '' }}">
        
            <x-ui.menus.icon-sub-menu-item label="View user" href="{{route('user.view')}}"/>
            <x-ui.menus.icon-sub-menu-item label="Add user" href="{{route('user.add')}}"/>
            <x-ui.menus.icon-sub-menu-item label="Change password" href="{{ route('user.password') }}"/>
        
      </x-ui.menus.icon-menu-item>

      
      <x-ui.menus.icon-menu-item  icon="message-circle" label="Manage profile" href="#" class="treeview {{  ($prefix == '/profile') ? 'active' : '' }}">
        <x-ui.menus.icon-sub-menu-item label="View profile" href="{{ route('profile.view') }}"/>
      </x-ui.menus.icon-menu-item>
      
      <x-ui.menus.icon-menu-item  icon="message-circle" label="Setup management" href="#" class="treeview {{  ($prefix == '/setups') ? 'active' : '' }}">
        <x-ui.menus.icon-sub-menu-item label="Student class" href="{{ route('student.class.view') }}"/>
        <x-ui.menus.icon-sub-menu-item label="Student year" href="{{ route('student.year.view') }}"/>
        <x-ui.menus.icon-sub-menu-item label="Student group" href="{{ route('student.group.view') }}"/>
        <x-ui.menus.icon-sub-menu-item label="Student shift" href="{{ route('student.shift.view') }}"/>
      </x-ui.menus.icon-menu-item>

      <li class="header nav-small-cap">User Interface</li>

      <li class="treeview">
        <a href="#">
          <i data-feather="grid"></i>
          <span>Components</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="components_alerts.html"><i class="ti-more"></i>Alerts</a></li>
          <li><a href="components_badges.html"><i class="ti-more"></i>Badge</a></li>
          <li><a href="components_buttons.html"><i class="ti-more"></i>Buttons</a></li>
          <li><a href="components_sliders.html"><i class="ti-more"></i>Sliders</a></li>
          <li><a href="components_dropdown.html"><i class="ti-more"></i>Dropdown</a></li>
          <li><a href="components_modals.html"><i class="ti-more"></i>Modal</a></li>
          <li><a href="components_nestable.html"><i class="ti-more"></i>Nestable</a></li>
          <li><a href="components_progress_bars.html"><i class="ti-more"></i>Progress Bars</a></li>
        </ul>
      </li>

     

      

    </x-ui.tree>
    <!-- sidebar menu-->
  </section>

  <div class="sidebar-footer">
    <!-- item-->
    <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings" aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
    <!-- item-->
    <a href="mailbox_inbox.html" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="ti-email"></i></a>
    <!-- item-->
    <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="ti-lock"></i></a>
  </div>
</aside>