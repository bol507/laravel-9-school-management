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
            <div class="widget-user-header bg-black">
              <h3 class="widget-user-username">{{ $user->name }}</h3>
              <a href="{{route('profile.edit')}}" class="btn btn-success pull-right">Edit profile</a>
              <h6 class="widget-user-desc">{{ $user->user_type}}</h6>
              <h6 class="widget-user-desc">{{ $user->email}}</h6>

            </div>
            <picture class="widget-user-image">
              <img
                class="rounded-circle"
                src="{{ (!empty($user->profile_data?->image) ? url('upload/user_images/'.$user->profile_data->image ) : url('upload/no_image.jpg')) }}"
                alt="User Avatar">
            </picture>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">Mobile No</h5>
                    <span class="description-text">{{$user->profile_data?->mobile ?? 'Not provided' }}</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 br-1 bl-1">
                  <div class="description-block">
                    <h5 class="description-header">Address</h5>
                    <span class="description-text">{{$user->profile_data?->address ?? 'Not provided' }}</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">Gender</h5>
                    <span class="description-text">{{$user->profile_data?->gender ?? 'Not provided' }}</span>
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