@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Add exam type</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('exam.type.store') }}">
                @csrf
                <div class="row">

                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="name" class="control-label">Exam type name</label>
                      <span class="text-danger">*</span>
                      <div class="controls">
                        <input
                          value="{{ old('name')  }}"
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

                    <div class="form-group">
                      <label for="description" class="control-label">Description</label>
                      <div class="controls">
                        <input
                          value="{{ old('description') }}"
                          type="text"
                          name="description"
                          class="form-control"
                        >
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <!-- /.form-group -->

                    

                  </div> <!-- /.col-md-6 -->


                  <div class="col-12">
                    <input type="submit" class="btn btn-info" value="Submit">
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