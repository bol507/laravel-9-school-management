@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Change password</h4>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('user.password.update') }}">
                @csrf
                @method('PUT')
                <div class="row">

                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="old_password" class="control-label">Current password</label>
                      <div class="controls">
                        <input
                          type="password"
                          name="old_password"
                          class="form-control"
                          
                        >
                        @error('old_password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="password" class="control-label">New password</label>
                      <div class="controls">
                        <input
                          type="password"
                          name="password"
                          class="form-control"
                          
                        >
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="password_confirmation" class="control-label">Confirm password</label>
                      <div class="controls">
                        <input
                          type="password"
                          name="password_confirmation"
                          class="form-control"
                          
                        >
                        @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                  </div> <!-- /.col-md-6 -->


                  <div class="col-12">
                    <input type="submit" class="btn btn-info" value="Update">
                  </div>
                </div>
              </form>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
  </div>
  <!-- /.container-full -->
</div>
<!-- /.content-wrapper -->
</section>
@endsection