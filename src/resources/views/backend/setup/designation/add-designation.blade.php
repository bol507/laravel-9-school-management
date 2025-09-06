@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Add designation</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('designation.store') }}">
                @csrf
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name" class="control-label">Designation name</label>
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
                    </div>

                  </div> <!-- /.col-md-12 -->

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
  </div><!-- /.container-full -->
</div><!-- /.content-wrapper -->


@endsection