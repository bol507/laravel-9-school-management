@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Student promotion</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col">
              <form 
                method="POST" 
                action="{{ route('student.promotion.update',$docs->student->id) }}"
                enctype="multipart/form-data"
              >
                @csrf
                @method('PUT')
                <div class="row">
                  
                    <div class="form-group col-sm-12 col-md-4">
                      <label for="name" class="control-label">Student name</label>
                      <span class="text-danger">*</span>
                      <div class="controls">
                        <input
                          value="{{ old('name',$docs->student->user->name)  }}"
                          type="text"
                          name="name"
                          class="form-control"
                          required
                        >
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  
                    <div class="form-group col-sm-12 col-md-4">
                      <label for="father_name" class="control-label">Father's name</label>
                      <div class="controls">
                        <input
                          value="{{ old('father_name', $docs->student->profile->father_name) }}"
                          type="text"
                          name="father_name"
                          class="form-control"
                        >
                        @error('father_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div> <!-- /.form-group -->
                
                
                    <div class="form-group col-sm-12 col-md-4">
                      <label for="mother_name" class="control-label">Mother's name</label>
                      <div class="controls">
                        <input
                          value="{{ old('mother_name',$docs->student->profile->mother_name) }}"
                          type="text"
                          name="mother_name"
                          class="form-control"
                        >
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
                          value="{{ old('mobile',$docs->student->profile->mobile)  }}"
                          type="text"
                          name="mobile"
                          class="form-control"
                        >
                        @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div><!-- form-group -->
                
              
                    <div class="form-group col-sm-12 col-md-4">
                      <label for="address" class="control-label">Address</label>
                      <div class="controls">
                        <input
                          value="{{ old('address',$docs->student->profile->address) }}"
                          type="text"
                          name="address"
                          class="form-control"
                        >
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
                          {{ old( 'gender', $docs->student->profile->gender ) == $value ? 'selected' : '' }}
                        >
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
                          value="{{ old('religion',$docs->student->profile->religion)  }}"
                          type="text"
                          name="religion"
                          class="form-control"
                        >
                        @error('religion')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div><!-- form-group -->
                
              
                    <div class="form-group col-sm-12 col-md-4">
                      <label for="date_birth" class="control-label">Date of birth</label>
                      <div class="controls">
                        <input
                          value="{{ old('date_birth',$docs->student->profile->date_birth) }}"
                          type="date"
                          name="date_birth"
                          class="form-control"
                        >
                        @error('date_birth')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div> <!-- /.form-group -->
                 
                  <div class="form-group col-sm-12 col-md-4">
                      <label for="discount" class="control-label">Discount</label>
                      <div class="controls">
                        <input
                          value="{{ old('discount',$docs->student->discount->discount)  }}"
                          type="text"
                          name="discount"
                          class="form-control"
                        >
                        @error('discount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div><!-- form-group -->
                </div><!-- row -->

                <div class="row">
                  
                    <div class="form-group col col-sm-12 col-md-4">
                    <label for="year_id">Year</label>
                    <div class="controls">
                      <select
                        name="year_id"
                        required
                        class="form-control"
                        aria-invalid="false">
                        <option
                          value=""
                          selected=""
                          disabled="">
                          Select year
                        </option>
                        @foreach($docs->years as $year)
                        <option 
                          value="{{ $year->id}}" 
                          {{ old('year_id', $docs->student->year_id) == $year->id ? 'selected' : '' }}
                        >
                          {{ $year->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->

                    <div class="form-group col col-sm-12 col-md-4">
                    <label>Class</label>
                    <div class="controls">
                      <select
                        name="class_id"
                        required
                        class="form-control"
                        aria-invalid="false">
                        <option
                          value=""
                          selected=""
                          disabled="">
                          Select gender
                        </option>
                        @foreach($docs->classes as $class)
                        <option 
                          value="{{ $class->id}}" 
                          {{ old('class_id',$docs->student->class_id) == $class->id ? 'selected' : '' }}
                        >
                          {{ $class->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->
                  
                  <div class="form-group col col-sm-12 col-md-4">
                    <label>Group</label>
                    <div class="controls">
                      <select
                        name="group_id"
                        required
                        class="form-control"
                        aria-invalid="false">
                        <option
                          value=""
                          selected=""
                          disabled="">
                          Select gender
                        </option>
                        @foreach($docs->groups as $group)
                        <option 
                          value="{{ $group->id}}" 
                          {{ old('group_id', $docs->student->group_id) == $group->id ? 'selected' : '' }}
                        >
                          {{ $group->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->
                  
                
                
                    
                 
                </div><!-- row -->

                <div class="row">
                  
                    <div class="form-group col col-sm-12 col-md-4">
                    <label for="shift_id">Shif</label>
                    <div class="controls">
                      <select
                        name="shift_id"
                        required
                        class="form-control"
                        aria-invalid="false">
                        <option
                          value=""
                          selected=""
                          disabled="">
                          Select shift
                        </option>
                        @foreach($docs->shifts as $shift)
                        <option 
                          value="{{ $shift->id}}" 
                          {{ old('shift_id', $docs->student->shift_id) == $shift->id ? 'selected' : '' }}
                        >
                          {{ $shift->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->
                  
                  
                   <!-- image -->
                 
                    <div class="form-group col-sm-12 col-md-4">
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
                            src="{{ (!empty($docs->student->profile->image) ? url($docs->student->profile->image ) : url('upload/no_image.jpg')) }}" 
                            alt="User Avatar"
                            style="width:100px; height:100px; border:1px solid #ddd"
                          >
                        </picture>
                      </div>
                    </div><!-- form group -->
                 
                
                
                    
                 
                </div><!-- row -->

                <div class="row">  
                  <div class="col-12">
                    <input type="submit" class="btn btn-info" value="Promotion">
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