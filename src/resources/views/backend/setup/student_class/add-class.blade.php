@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Add student class</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('student.class.store') }}">
                @csrf
                <div class="row">

                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="name" class="control-label">Student class name</label>
                      <span class="text-danger">*</span>
                      <div class="controls">
                        <input
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