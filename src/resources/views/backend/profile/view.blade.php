@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black"  center center;">
              <h3 class="widget-user-username">{{ $user->name }}</h3>
              <a href="{{route('user.add')}}" class="btn btn-success pull-right">Edit profile</a>
              <h6 class="widget-user-desc">{{ $user->user_type}}</h6>
              <h6 class="widget-user-desc">{{ $user->email}}</h6>
              
            </div>
            <div class="widget-user-image">
              <img class="rounded-circle" src="{{ asset('backend/images/user3-128x128.jpg') }}" alt="User Avatar">
            </div>
            <div class="box-footer"> 
              <div class="row">
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">12K</h5>
                    <span class="description-text">FOLLOWERS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 br-1 bl-1">
                  <div class="description-block">
                    <h5 class="description-header">550</h5>
                    <span class="description-text">FOLLOWERS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">158</h5>
                    <span class="description-text">TWEETS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  </div>
</div>
@endsection