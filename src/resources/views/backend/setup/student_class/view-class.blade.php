@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Student class list</h3>
              <a
                href="{{route('student.class.add')}}"
                class="btn btn-success pull-right">
                Add student class
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div
                  class="container-fluid">

                  <div class="row justify-between">
                    <x-ui.show-entries 
                      :action="route('student.class.view')" 
                      :docs="$docs" 
                    />
                    <x-ui.search
                      :action="route('student.class.view')"
                      :search="$search" 
                    />
                  </div>
                  
                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs"
                    :columns="[
                      'name'        => 'Name',
                    ]"
                    :actions="[
                      
                      'Edit' => fn($doc) => [
                        'href'  => route('student.class.edit', $doc),
                        'class' => 'btn-info',
                      ],
                      'Delete' => fn($doc) => [
                          'href'  => 'javascript:void(0);',
                          'class' => 'btn-danger',
                          'attrs' => [
                              'data-modal-confirm' => 'deleteClass',
                              'data-url'           => route('student.class.destroy', $doc),
                              
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
        id="deleteClass"
        method="DELETE"
        submitText="Delete"
        title="Delete student class"
        message="Are you sure you want to delete this class?" 
      />
    </section>
@endsection