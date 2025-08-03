<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{asset('backend/images/favicon.ico')}}">
  <title>School Management System</title>
  <!-- Vendors Style-->
	<link rel="stylesheet" href="{{asset('backend/css/vendors_css.css')}}">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="{{asset('backend/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('backend/css/skin_color.css')}}">
  <!-- toastify js -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>
<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">

  @include('admin.body.header')
  @include('admin.body.sidebar')
  <!-- content page -->
  @yield('admin')

  @include('admin.body.footer')

  <!-- Vendor JS -->
	<script src="{{asset('backend/js/vendors.min.js')}}"></script>
  <script src="{{asset('assets/icons/feather-icons/feather.min.js')}}"></script>	
	<script src="{{asset('assets/vendor_components/easypiechart/dist/jquery.easypiechart.js')}}"></script>
	<script src="{{asset('assets/vendor_components/apexcharts-bundle/irregular-data-series.js')}}"></script>
	<script src="{{asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js')}}"></script>
  <script src="{{asset('assets/vendor_components/datatable/datatables.min.js')}}"></script>
	<script src="{{asset('backend/js/pages/data-table.js')}}"></script>
  <!-- Toastify js -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	<!-- Sunny Admin App -->
	<script src="{{asset('backend/js/template.js')}}"></script>
	<script src="{{asset('backend/js/pages/dashboard.js')}}"></script>
  <!-- Notifications -->
  @include('admin.partials.notifications')
</body>
</html>