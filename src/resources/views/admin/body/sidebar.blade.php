@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
@endphp
<!-- Left side column. contains the logo and sidebar -->
<aside class=" main-sidebar">

  <section class="sidebar">

    <div class="user-profile">
      <div class="ulogo">
        <a href="{{ route('dashboard') }}">
          <!-- logo for regular state and mobile devices -->
          <div class="flex items-center justify-center">
            <img src="{{asset('backend/images/logo-dark.png')}}" alt="logo">
            <h3><b>School</b> admin</h3>
          </div>
        </a>
      </div>
    </div>

    <!-- sidebar menu-->
    <x-ui.tree>
      <x-ui.menus.icon-menu-item icon="pie-chart" label="Dashboard" href="{{ route('dashboard') }}" class="{{ ($route == 'dashboard') ? 'active' : '' }}" />
      @if(Auth::user()->user_type == 'Admin')
      <x-ui.menus.icon-menu-item icon="message-circle" label="Manage user" class="treeview {{  ($prefix == '/users') ? 'active' : '' }}">
        <x-ui.menus.icon-sub-menu-item label="View user" href="{{route('user.view')}}" />
        <x-ui.menus.icon-sub-menu-item label="Add user" href="{{route('user.add')}}" />
      </x-ui.menus.icon-menu-item>
      @endif

      <x-ui.menus.icon-menu-item icon="message-circle" label="Manage profile" class="treeview {{  ($prefix == '/profile') ? 'active' : '' }}">
        <x-ui.menus.icon-sub-menu-item label="View profile" href="{{ route('profile.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Change password" href="{{ route('user.password') }}" />
      </x-ui.menus.icon-menu-item>

      <x-ui.menus.icon-menu-item icon="message-circle" label="Setup management" class="treeview {{  ($prefix == '/setups') ? 'active' : '' }}">
        <x-ui.menus.icon-sub-menu-item label="Student class" href="{{ route('student.class.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Student year" href="{{ route('student.year.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Student group" href="{{ route('student.group.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Student shift" href="{{ route('student.shift.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Fee category" href="{{ route('fee.category.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Fee amount" href="{{ route('fee.amount.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Exam type" href="{{ route('exam.type.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="School subject" href="{{ route('school.subject.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Asign subject" href="{{ route('assign.subject.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Designation" href="{{ route('designation.view') }}" />
      </x-ui.menus.icon-menu-item>

      <x-ui.menus.icon-menu-item icon="message-circle" label="Student Management" class="treeview {{  ($prefix == '/students') ? 'active' : '' }}">
        <x-ui.menus.icon-sub-menu-item label="Student registration" href="{{ route('student.registration.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Registration fee" href="{{ route('registration.fee.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Monthly fee" href="{{ route('monthly.fee.view') }}" />
        <x-ui.menus.icon-sub-menu-item label="Exam fee" href="{{ route('exam.fee.view') }}" />
      </x-ui.menus.icon-menu-item>

      <x-ui.menus.icon-menu-item icon="message-circle" label="Employee Management" class="treeview {{  ($prefix == '/employees') ? 'active' : '' }}">
        <x-ui.menus.icon-sub-menu-item label="Employee registration" href="{{ route('employee.registration.view') }}" />
      </x-ui.menus.icon-menu-item>
    </x-ui.tree> <!-- sidebar menu-->

  </section>

  <div class="sidebar-footer">
    <!-- item-->
    <x-ui.buttons.icon icon="setting" href="#" />
    <!-- item-->
    <a href="mailbox_inbox.html" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="ti-email"></i></a>
    <!-- item-->
    <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="ti-lock"></i></a>
  </div>

</aside>
