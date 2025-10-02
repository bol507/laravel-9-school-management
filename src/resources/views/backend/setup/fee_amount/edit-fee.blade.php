@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
          <h4 class="box-title">Edit fee amount</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <div class="row">
            <div class="col">
              <form method="POST" action="{{ route('fee.amount.update',$doc[0]->fee_category_id) }}">
                @csrf
                @method('PUT')
                <!-- fee category -->
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
                        @foreach($doc->fee_categories as $category)
                        <option
                          value="{{ $category->id }}"
                          {{ ($doc[0]->fee_category_id == $category->id) ? "selected": "" }}>
                          {{ $category->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div> <!-- form-group -->
                </div><!-- row -->

                @foreach($doc as $edit)
                <div id="delete-extra-item" class="delete-extra-item">
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
                          @foreach($doc->classes as $class)
                          <option
                            value="{{ $class->id }}"
                            {{ ($edit->class_id == $class->id) ? 'selected' : '' }}>
                            {{ $class->name }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                    </div> <!-- form-group -->

                    <div class="form-group col col-sm-12 col-md-6">
                      <label for="amount" class="control-label">fee amount <span class="text-danger">*</span></label>

                      <div class="flex">
                        <input
                          value="{{ $edit->amount }}"
                          type="text"
                          name="amount[]"
                          class="form-control"
                          required>
                        <x-ui.buttons.icon-circle-plus-success class="btn btn-success ml-2 add-event-more " />
                        <x-ui.buttons.icon-circle-minus-danger class="btn btn-danger ml-2 remove-event-more " />
                        @error('amount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div> <!-- form-group -->
                  </div><!-- row -->
                </div> <!-- delete extra item -->
                @endforeach
                <div id="extra-items-container"></div>

                <div class="row">
                  <div class="col-12">
                    <input type="submit" class="btn btn-info" value="Update">
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

<div style="display:none;">
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
              @foreach($doc->classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
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