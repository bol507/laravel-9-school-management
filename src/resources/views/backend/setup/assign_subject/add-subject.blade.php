@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Add assign subject</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('assign.subject.store') }}">
                @csrf
                <div class="row">
                  <div class="form-group col col-sm-12 col-md-12">
                    <label>Class name <span class="text-danger">*</span></label>
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
                          Select class
                        </option>
                        @foreach($docs->classes as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->
                </div><!-- row -->

                <div class="row">
                  <div class="form-group col col-sm-12 col-md-3">
                    <label>Student subject<span class="text-danger">*</span></label>
                    <div class="controls">
                      <select
                        name="subject_id[]"
                        required
                        class="form-control"
                        aria-invalid="false">
                        <option
                          value=""
                          selected=""
                          disabled="">
                          Select student subject
                        </option>
                        @foreach($docs->subjects as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->

                  <div class="form-group col col-sm-12 col-md-3">
                    <label for="full_mark" class="control-label">Full mark<span class="text-danger">*</span></label>
                      <input
                        type="text"
                        name="full_mark[]"
                        class="form-control"
                        required>
                      @error('full_mark.*')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div> <!-- form-group -->

                  <div class="form-group col col-sm-12 col-md-3">
                    <label for="pass_mark" class="control-label">Pass mark<span class="text-danger">*</span></label>
                      <input
                        type="text"
                        name="pass_mark[]"
                        class="form-control"
                        required>
                      @error('pass_mark.*')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div> <!-- form-group -->

                  <div class="form-group col col-sm-6 col-md-3">
                    <label for="subjective_mark" class="control-label">Subjective mark<span class="text-danger">*</span></label>
                      <div class="flex">
                      <input
                          type="text"
                          name="subjective_mark[]"
                          class="form-control"
                          required>
                        <x-ui.buttons.icon-circle-plus-success  class="btn btn-success ml-2 add-event-more " />
                      </div>
                      @error('subjective_mark.*')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    
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

<div style="visibility:hidden;">
  <div id="add-extra-item" class="add-extra-item">
    <div class="delete-extra-item">
      <div class="form-row">
        <div class="form-group col col-sm-12 col-md-3">
                    <label>Student subject<span class="text-danger">*</span></label>
                    <div class="controls">
                      <select
                        name="subject_id[]"
                        required
                        class="form-control"
                        aria-invalid="false">
                        <option
                          value=""
                          selected=""
                          disabled="">
                          Select student subject
                        </option>
                        @foreach($docs->subjects as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->

                  <div class="form-group col col-sm-12 col-md-3">
                    <label for="full_mark" class="control-label">Full mark<span class="text-danger">*</span></label>
                      <input
                        type="text"
                        name="full_mark[]"
                        class="form-control"
                        required>
                      @error('full_mark')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div> <!-- form-group -->

                  <div class="form-group col col-sm-12 col-md-3">
                    <label for="pass_mark" class="control-label">Pass mark<span class="text-danger">*</span></label>
                      <input
                        type="text"
                        name="pass_mark[]"
                        class="form-control"
                        required>
                      @error('pass_mark')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div> <!-- form-group -->

                  <div class="form-group col col-sm-6 col-md-3">
                    <label for="subjective_mark" class="control-label">Subjective mark<span class="text-danger">*</span></label>
                      <div class="flex">
                      <input
                          type="text"
                          name="subjective_mark[]"
                          class="form-control"
                          required>
                        <x-ui.buttons.icon-circle-plus-success  class="btn btn-success ml-2 add-event-more " />
                        <x-ui.buttons.icon-circle-minus-danger class="btn btn-danger ml-2 remove-event-more" />
                      </div>
                      @error('subjective_mark')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    
                  </div> <!-- form-group -->
      </div><!-- form-row -->
    </div>
  </div>
</div>


@endsection