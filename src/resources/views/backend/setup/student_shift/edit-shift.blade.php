@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Edit student shift</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('student.shift.update' , $doc->id) }}">
                @csrf
                @method('PUT')
                <div class="row">

                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="name" class="control-label">Name</label>
                      <span class="text-danger">*</span>
                      <div class="controls">
                        <input
                          type="text"
                          name="name"
                          class="form-control"
                          required
                          value="{{$doc->name}}"
                        >
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="description" class="control-label">Description</label>
                      <span class="text-danger">*</span>
                      <div class="controls">
                        <input
                          type="text"
                          name="description"
                          class="form-control"
                          required
                          value="{{$doc->description}}"
                        >
                        @error('description')
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
</section>
@endsection