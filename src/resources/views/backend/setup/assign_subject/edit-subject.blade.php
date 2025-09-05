@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Edit assign subject</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('assign.subject.update',$docs[0]->class_id) }}">
                @csrf
                @method('PUT')
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
                        <option 
                          value="{{ $doc->id }}"
                          {{ ($docs[0]->class_id == $doc->id) ? "selected": "" }}
                        >
                          {{ $doc->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->
                </div><!-- row -->

                @foreach($docs as $edit)
                  <div id="delete-extra-item" class="delete-extra-item">
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
                          <option value="{{ $doc->id }}"
                          {{ (old('subject_id.'.$loop->index) == $doc->id || $edit->subject_id == $doc->id) ? 'selected' : '' }}
                          >
                            {{ $doc->name }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                    </div> <!-- form-group -->

                    <div class="form-group col col-sm-12 col-md-3">
                      <label for="full_mark_{{ $loop->index }}" class="control-label">Full mark<span class="text-danger">*</span></label>
                        <input
                          value="{{ old('full_mark.'.$loop->index, $edit->full_mark ?? '') }}"
                          type="text"
                          name="full_mark[]"
                          class="form-control"
                          required>
                        @error('full_mark.'.$loop->index)
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> <!-- form-group -->

                    <div class="form-group col col-sm-12 col-md-3">
                      <label for="pass_mark_{{$loop->index}}" class="control-label">Pass mark<span class="text-danger">*</span></label>
                        <input
                          value="{{ old('pass_mark.'.$loop->index, $edit->pass_mark ?? '') }}"
                          type="text"
                          name="pass_mark[]"
                          class="form-control"
                          required>
                        @error('pass_mark.'.$loop->index)
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> <!-- form-group -->

                    <div class="form-group col col-sm-6 col-md-3">
                      <label for="subjective_mark_{{$loop->index}}" class="control-label">Subjective mark<span class="text-danger">*</span></label>
                        <div class="flex">
                        <input
                            value="{{ old('subjective_mark.'.$loop->index, $edit->subjective_mark) }}"
                            type="text"
                            name="subjective_mark[]"
                            class="form-control"
                            required>
                          <x-ui.buttons.icon-circle-plus-success  class="btn btn-success ml-2 add-event-more " />
                          <x-ui.buttons.icon-circle-minus-danger class="btn btn-danger ml-2 remove-event-more " />
                        </div>
                        @error('subjective_mark.'.$loop->index)
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> <!-- form-group -->

                  </div><!-- row -->
                  </div> <!-- delete extra item -->
                @endforeach

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