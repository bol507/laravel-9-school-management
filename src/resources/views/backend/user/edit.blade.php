@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Update user</h4>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
          @if ($errors->any())
          <div>
            <ul>
              @foreach ($errors->all() as $error)
              <li class="text-danger">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <div class="row">
            <div class="col">
              <form method="post" action="{{ route('user.store') }}">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>User type</label>
                      <div class="controls">
                        <select
                          name="user_type"
                          id="usertype"
                          required
                          class="form-control"
                          aria-invalid="false">
                          <option
                            value=""
                            @if(empty($editUser->user_type)) selected disabled @endif
                            >
                            Select user type
                          </option>
                          <option value="Admin" @if($editUser->user_type == 'Admin') selected @endif>
                            Admin
                          </option>
                          <option value="User" @if($editUser->user_type == 'User') selected @endif>
                            User
                          </option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="text" class="control-label">Name</label>
                      <div class="controls">
                        <input
                          type="text"
                          name="name"
                          class="form-control"
                          required
                          value="{{$editUser->name}}">
                      </div>
                      @error('name')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="control-label">Email</label>
                      <div class="controls">
                        <input
                          type="email"
                          name="email"
                          class="form-control"
                          required
                          value="{{$editUser->email}}">
                      </div>
                      @error('email')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
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