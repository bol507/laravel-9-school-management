@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Student group list</h3>
              <a
                href="{{route('student.group.add')}}"
                class="btn btn-success pull-right">
                Add student group
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div
                  class="container-fluid">
                  <div class="row">
                    <x-ui.show-entries 
                      :action="route('student.group.view')" 
                      :docs="$docs" 
                    />
                    <x-ui.search 
                      :action="route('student.group.view')" 
                    />
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
                        'href'  => route('student.group.edit', $doc),
                        'class' => 'btn-info',
                      ],
                      'Delete' => fn($doc) => [
                          'href'  => 'javascript:void(0);',
                          'class' => 'btn-danger',
                          'attrs' => [
                              'data-modal-confirm' => 'deleteGroup',
                              'data-url'           => route('student.group.destroy', $doc),
                              
                          ],
                      ],
                    
                    ]" />

                  <div class="row items-center justify-between">
                    <x-ui.pagination-info :docs="$docs" class="text-muted" />
                    <x-ui.paginator :docs="$docs" />
                  </div>

                </div>
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
        id="deleteGroup"
        method="DELETE"
        submitText="Delete"
        title="Delete student group"
        message="Are you sure you want to delete this group?" 
      />
    </section>
@endsection