@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Manage profile</h4>

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
              <form 
                method="POST" 
                action="{{ route('profile.update', $editUser->profile_data->id) }}"
                enctype="multipart/form-data"
              >
                @csrf
                @method('PUT')
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
                  <!-- mobile -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="mobile" class="control-label">Mobile</label>
                      <div class="controls">
                        <input
                          type="text"
                          name="mobile"
                          class="form-control"
                          required
                          value="{{$editUser->profile_data->mobile}}">
                      </div>
                      @error('mobile')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <!-- address -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="address" class="control-label">Address</label>
                      <div class="controls">
                        <input
                          type="text"
                          name="address"
                          class="form-control"
                          required
                          value="{{$editUser->profile_data->address}}">
                      </div>
                      @error('address')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <!-- religion -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="religion" class="control-label">Religion</label>
                      <div class="controls">
                        <input
                          type="text"
                          name="religion"
                          class="form-control"
                          required
                          value="{{$editUser->profile_data->religion}}">
                      </div>
                      @error('religion')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <!-- blood_group -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Blood group</label>
                      <div class="controls">
                        <select 
                          name="blood_group" 
                          id="blood_group" 
                          required 
                          class="form-control"
                          aria-invalid="false"
                        >
                          <option 
                             value=""
                            @if(empty($editUser->profile_data->blood_group)) selected disabled @endif
                            >
                            Select blood group
                          </option>
                          <option value="a+" @if($editUser->profile_data->blood_group == 'a+') selected @endif>A+</option>
                          <option value="a-" @if($editUser->profile_data->blood_group == 'a-') selected @endif>A-</option>
                          <option value="b+" @if($editUser->profile_data->blood_group == 'b+') selected @endif>B+</option>
                          <option value="b-" @if($editUser->profile_data->blood_group == 'b-') selected @endif>B-</option>
                          <option value="o+" @if($editUser->profile_data->blood_group == 'o+') selected @endif>O+</option>
                          <option value="o-" @if($editUser->profile_data->blood_group == 'o-') selected @endif>O-</option>
                          <option value="ab+" @if($editUser->profile_data->blood_group == 'ab+') selected @endif>AB+</option>
                          <option value="ab-" @if($editUser->profile_data->blood_group == 'ab-') selected @endif>AB-</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- /.col-md-6 -->

                  

                  <!-- nationality -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nationality" class="control-label">Nationality</label>
                      <div class="controls">
                        <input
                          type="text"
                          name="nationality"
                          class="form-control"
                          required
                          value="{{$editUser->profile_data->nationality}}">
                      </div>
                      @error('nationality')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <!-- status -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="status" class="control-label">Status</label>
                      <div class="controls">
                        <select
                          name="status"
                          id="status"
                          required
                          class="form-control"
                          aria-invalid="false"
                        >
                          <option
                            value=""
                            @if(empty($editUser->profile_data->status)) selected disabled @endif
                            >
                            Select status
                          </option>
                          <option value="active" @if($editUser->profile_data->status == 'active') selected @endif>Active</option>
                          <option value="inactive" @if($editUser->profile_data->status == 'inactive') selected @endif>Inactive</option>
                        </select>
                      </div>
                      @error('status')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <!-- Gender -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gender" class="control-label">Gender</label>
                      <div class="controls">
                        <select 
                          name="gender" 
                          id="gender" 
                          required 
                          class="form-control"
                          aria-invalid="false"
                        >
                          <option 
                            value=""
                            @if(empty($editUser->profile_data->gender)) selected disabled @endif
                            >
                            Select gender
                          </option>
                          <option value="male" @if($editUser->profile_data->gender == 'male') selected @endif>Male</option>
                          <option value="female" @if($editUser->profile_data->gender == 'female') selected @endif>Female</option>
                          <option value="other" @if($editUser->profile_data->gender == 'other') selected @endif>Other</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <!-- image -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="image" class="control-label">Image</label>
                      <div class="controls">
                        <input
                          id="image"
                          type="file"
                          name="image"
                          class="form-control"
                        >
                      </div>
                      @error('image')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <div class="controls">
                        <picture>
                          <img 
                            id="show-image" 
                            src="{{ (!empty($editUser->profile_data->image) ? url('upload/user_images/'.$editUser->profile_data->image ) : url('upload/no_image.jpg')) }}" 
                            alt="User Avatar"
                            style="width:100px; height:100px; border:1px solid #ddd"
                          >
                        </picture>
                      </div>
                    </div>
                  </div> <!-- /.col-md-6 -->

                  <!-- submit -->
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
@include('backend.profile.partials.image-change')
@endsection