@extends('admin.main')
@section('admin')

        <section class="content">
            <div class="box">

                <div class="box-header with-border">
                    <h4 class="box-title">Add employee</h4>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form
                                method="POST"
                                action="{{ route('employee.registration.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="name" class="control-label">Employee name</label>
                                        <span class="text-danger">*</span>
                                        <div class="controls">
                                            <input
                                                value="{{ old('name')  }}"
                                                type="text"
                                                name="name"
                                                class="form-control"
                                                required>
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div><!-- /.form-group -->


                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="father_name" class="control-label">Father's name</label>
                                        <div class="controls">
                                            <input
                                                value="{{ old('father_name') }}"
                                                type="text"
                                                name="father_name"
                                                class="form-control">
                                            @error('father_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> <!-- /.form-group -->


                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="mother_name" class="control-label">Mother's name</label>
                                        <div class="controls">
                                            <input
                                                value="{{ old('mother_name') }}"
                                                type="text"
                                                name="mother_name"
                                                class="form-control">
                                            @error('mother_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div><!-- /.form-group -->

                                </div><!-- row -->

                                <div class="row">

                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="mobile" class="control-label">Mobile number</label>
                                        <div class="controls">
                                            <input
                                                value="{{ old('mobile')  }}"
                                                type="text"
                                                name="mobile"
                                                class="form-control">
                                            @error('mobile')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div><!-- form-group -->


                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="address" class="control-label">Address</label>
                                        <div class="controls">
                                            <input
                                                value="{{ old('address') }}"
                                                type="text"
                                                name="address"
                                                class="form-control">
                                            @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> <!-- /.form-group -->

                                    <div class="form-group col col-sm-12 col-md-4">
                                        <label>Gender</label>
                                        <div class="controls">
                                            <select
                                                name="gender"
                                                required
                                                class="form-control"
                                                aria-invalid="false">
                                                <option
                                                    value=""
                                                    selected=""
                                                    disabled="">
                                                    Select gender
                                                </option>
                                                @foreach($docs->genderOptions as $value => $label)
                                                <option
                                                    value="{{ $value}}"
                                                    {{ old('gender') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> <!-- form-group -->
                                </div><!-- row -->

                                <div class="row">

                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="religion" class="control-label">Religion</label>
                                        <div class="controls">
                                            <input
                                                value="{{ old('religion')  }}"
                                                type="text"
                                                name="religion"
                                                class="form-control">
                                            @error('religion')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div><!-- form-group -->


                                    <div class="form-group col-sm-12 col-md-4">
                                        <label for="date_birth" class="control-label">Date of birth</label>
                                        <div class="controls">
                                            <input
                                                value="{{ old('date_birth') }}"
                                                type="date"
                                                name="date_birth"
                                                class="form-control">
                                            @error('date_birth')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> <!-- /.form-group -->

                                    <div class="form-group col col-sm-12 col-md-4">
                                        <label for="designation_id">Designation</label>
                                        <div class="controls">
                                            <select
                                                name="designation_id"
                                                required
                                                class="form-control"
                                                aria-invalid="false">
                                                <option
                                                    value=""
                                                    selected=""
                                                    disabled="">
                                                    Select designation
                                                </option>
                                                @foreach($docs->designations as $designation)
                                                <option
                                                    value="{{ $designation->id}}"
                                                    {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> <!-- form-group -->

                                </div><!-- row -->

                                <div class="row">

                                    <div class="form-group col-sm-12 col-md-3">
                                        <label for="salary" class="control-label">Salary</label>
                                        <div class="controls">
                                            <input
                                                value="{{ old('salary')  }}"
                                                type="number"
                                                name="salary"
                                                class="form-control">
                                            @error('salary')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div><!-- form-group -->

                                    <div class="form-group col-sm-12 col-md-3">
                                        <label for="date_join" class="control-label">Joining date</label>
                                        <div class="controls">
                                            <input
                                                value="{{ old('date_join') }}"
                                                type="date"
                                                name="date_join"
                                                class="form-control">
                                            @error('date_join')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> <!-- /.form-group -->


                                    <!-- image -->

                                    <div class="form-group col-sm-12 col-md-3"  >
                                        <label for="image" class="control-label">Image</label>
                                        <div class="controls">
                                            <input
                                                id="image"
                                                type="file"
                                                name="image"
                                                class="form-control">
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
                                                    src="{{ (!empty($docs->profile_data->image) ? url('upload/user_images/'.$docs->profile_data->image ) : url('upload/no_image.jpg') }}"
                                                    alt="User Avatar"
                                                    style="width:100px; height:100px; border:1px solid #ddd">
                                            </picture>
                                        </div>
                                    </div><!-- form group -->






                                </div><!-- row -->

                                <div class="row">
                                    <div class="col-12">
                                        <input type="submit" class="btn btn-info" value="Submit">
                                    </div>
                                </div>
                            </form>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.box-body -->

            </div><!-- /.box -->

</section>
@endsection
