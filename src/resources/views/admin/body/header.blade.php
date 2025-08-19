@php
  $user = Auth::user();
@endphp
<header class="main-header">
  <!-- Header Navbar -->
  <nav class="navbar pl-8 ">
    <!-- Sidebar toggle button-->
    <div>
      <ul class="nav mb-0 pl-0">
        <li class="relative inline-flex align-middle">
            <x-ui.header.icon icon="menu" href="#" />
        </li>
        <li class="relative inline-flex align-middle">
            <x-ui.header.icon icon="crop-free" href="#" title="Full Screen" />
        </li>
        <li class="relative inline-flex align-middle  d-none d-xl-inline-block">
            <x-ui.header.icon icon="check-square" href="#"  />
        </li>
        <li class="relative inline-flex align-middle  d-none d-xl-inline-block">
            <x-ui.header.icon icon="calendar" href="#"  />
        </li>
      </ul>
    </div>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav mb-0 pl-0">
        <!-- full Screen -->
        <li class="search-bar">
          <div class="search-group">
            <input 
              type="text" 
              name="search" 
              class="search-input" 
              style="background-color: transparent;">
            <svg 
              width="24"
              height="24" 
              aria-hidden="true">
              <use xlink:href="{{ asset('assets/icons/icons.svg#search' ) }}"></use>
            </svg>
          </div>
        </li>
        <!-- Notifications -->
        <li class="dropdown">
          <x-ui.header.icon icon="bell" href="#" />
          <ul class="dropdown-menu animated bounceIn">

            <li class="header">
              <div class="p-20">
                <div class="flexbox">
                  <div>
                    <h4 class="mb-0 mt-0">Notifications</h4>
                  </div>
                  <div>
                    <a href="#" class="text-danger">Clear All</a>
                  </div>
                </div>
              </div>
            </li>

            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu sm-scrol">
                <li>
                  <a href="#">
                    <i class="fa fa-users text-info"></i> Curabitur id eros quis nunc suscipit blandit.
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-warning text-warning"></i> Duis malesuada justo eu sapien elementum, in semper diam posuere.
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-users text-danger"></i> Donec at nisi sit amet tortor commodo porttitor pretium a erat.
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-shopping-cart text-success"></i> In gravida mauris et nisi
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-user text-danger"></i> Praesent eu lacus in libero dictum fermentum.
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-user text-primary"></i> Nunc fringilla lorem
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-user text-success"></i> Nullam euismod dolor ut quam interdum, at scelerisque ipsum imperdiet.
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer">
              <a href="#">View all</a>
            </li>
          </ul>
        </li>

        <!-- User Account-->
        <li class="dropdown user-menu">
          <a href="#" class="waves-effect waves-light rounded dropdown-toggle p-0" data-toggle="dropdown" title="User">
            <picture>
              <img 
                src="{{ (!empty($user->profile_data->image) ? url('upload/user_images/'.$user->profile_data->image ) : url('upload/no_image.jpg')) }}"
                alt="avatar">
            </picture>
          </a>
          <ul class="dropdown-menu animated flipInX">
            <li class="user-body">
              <a class="dropdown-item" href="#"><i class="ti-user text-muted mr-2"></i> Profile</a>
              <a class="dropdown-item" href="#"><i class="ti-wallet text-muted mr-2"></i> My Wallet</a>
              <a class="dropdown-item" href="#"><i class="ti-settings text-muted mr-2"></i> Settings</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{route('admin.logout')}}">
                <i class="ti-lock text-muted mr-2"></i> Logout
              </a>
            </li>
          </ul>
        </li>
        <li>
          <x-ui.header.icon icon="setting" href="#" />
        </li>

      </ul>
    </div>
  </nav>
</header>