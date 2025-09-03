@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Add fee amount</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('fee.amount.store') }}">
                @csrf
                <div class="row">
                  <div class="form-group col col-sm-12 col-md-12">
                    <label>Fee category <span class="text-danger">*</span></label>
                    <div class="controls">
                      <select
                        name="fee_category_id"
                        required
                        class="form-control"
                        aria-invalid="false">
                        <option
                          value=""
                          selected=""
                          disabled="">
                          Select fee category
                        </option>
                        @foreach($docs->fee_categories as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->
                </div><!-- row -->
                <div class="row">
                  <div class="form-group col col-sm-12 col-md-6">
                    <label>Student class <span class="text-danger">*</span></label>
                    <div class="controls">
                      <select
                        name="class_id[]"
                        required
                        class="form-control"
                        aria-invalid="false">
                        <option
                          value=""
                          selected=""
                          disabled="">
                          Select student class
                        </option>
                        @foreach($docs->classes as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->

                  <div class="form-group col col-sm-12 col-md-6">
                    <label for="amount" class="control-label">fee amount <span class="text-danger">*</span></label>

                    <div class="flex">
                      <input
                        type="text"
                        name="amount[]"
                        class="form-control"
                        required>
                      <x-ui.buttons.icon-circle-plus-success  class="btn btn-success ml-2 add-event-more " />
                      @error('amount')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div> <!-- form-group -->
                </div><!-- row -->

                <div id="extra-items-container"></div>

                <div class="row">
                  <div class="col-12">
                    <input type="submit" class="btn btn-info" value="Submit">
                  </div>
                </div><!--row -->
              </form>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div> <!-- /.box-body -->

      </div> <!-- /.box -->
    </section>
  </div><!-- /.container-full -->
</div><!-- /.content-wrapper -->

<div style="visibility:hidden;">
  <div id="add-extra-item" class="add-extra-item">
    <div id="delete-extra-item" class="delete-extra-item">
      <div class="form-row">
        <div class="form-group col col-sm-12 col-md-6">
          <label>Student class <span class="text-danger">*</span></label>
          <div class="controls">
            <select
              name="class_id[]"
              required
              class="form-control"
              aria-invalid="false">
              <option
                value=""
                selected=""
                disabled="">
                Select student class
              </option>
              @foreach($docs->classes as $doc)
              <option value="{{ $doc->id }}">{{ $doc->name }}</option>
              @endforeach
            </select>
          </div>
        </div> <!-- form-group -->

        <div class="form-group col col-sm-12 col-md-6">
          <label for="amount" class="control-label">fee amount <span class="text-danger">*</span></label>

          <div class="flex">
            <input
              type="text"
              name="amount[]"
              class="form-control"
              required>
            <x-ui.buttons.icon-circle-plus-success class="btn btn-success ml-2 add-event-more" />
            <x-ui.buttons.icon-circle-minus-danger class="btn btn-danger ml-2 remove-event-more" />
            @error('amount')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div> <!-- form-group -->
      </div><!-- form-row -->
    </div>
  </div>
</div>


@endsection