@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Student shift list</h3>
              <a
                href="{{route('student.shift.add')}}"
                class="btn btn-success pull-right">
                Add student shift
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('student.shift.view')"
                      :docs="$docs" />
                    <x-ui.search
                      :action="route('student.shift.view')" />
                  </div>
                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs"
                    :columns="[
                      'name'        => 'Name',
                      'description' => 'Description',
                    ]"
                    :actions="[
                      
                      'Edit' => fn($doc) => [
                        'href'  => route('student.shift.edit', $doc),
                        'class' => 'btn-info',
                      ],
                      'Delete' => fn($doc) => [
                          'href'  => 'javascript:void(0);',
                          'class' => 'btn-danger',
                          'attrs' => [
                              'data-modal-confirm' => 'deleteShift',
                              'data-url'           => route('student.shift.destroy', $doc),
                              
                          ],
                      ],
                    
                    ]" />

                  <div class="row">
                    <x-ui.pagination-info :docs="$docs" class="text-muted" />
                    <x-ui.paginator :docs="$docs" />
                  </div>

                </div><!-- container-fluid-->
                <!-- table-responsive -->
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <x-ui.dialog
        id="deleteShift"
        method="DELETE"
        submitText="Delete"
        title="Delete student shift"
        message="Are you sure you want to delete this shift?" />
    </section>
@endsection