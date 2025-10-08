<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('backend/images/favicon.ico')}}">
    <title>School Management System</title>
    <!-- toastify js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @vite(['resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="m-0" x-data="sidebarState()" x-init="$store.theme.init()" :data-theme="$store.theme.current">
    <div class="wrapper">
        @include('admin.body.header')
        @include('admin.body.sidebar')
        <!-- content page -->
        <div class="content-wrapper" :class="{ 'collapsed': !sidebarOpen }">
            <div class="container-full">
                @yield('admin')
            </div>
        </div>

        @include('admin.body.footer')
    </div>

    <!-- Toastify js -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    @vite(['resources/js/app.js'])
    <!-- Notifications -->
    @include('admin.partials.notifications')
</body>

</html>
