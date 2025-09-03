@extends('admin.main')
@section('admin')
<div class="content-wrapper">
  <div class="container-full">

    <!-- Main content -->
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
                  <div class="row">
                    <x-ui.show-entries 
                      :action="route('student.class.view')" 
                      :docs="$docs" 
                    />
                    <x-ui.search
                      :action="route('student.class.view')"
                      :search="$search" 
                    />
                  </div>
                  <table
                    id="table"
                    class="table table-bordered table-striped my-2">
                    <thead>
                      <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($docs as $key => $class)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$class->name}}</td>
                        <td>
                          <a href="{{ route('student.class.edit', $class->id) }}" class="btn btn-info">Edit</a>
                          <a
                            href="javascript:void(0);"
                            class="btn btn-danger"
                            data-modal-confirm="deleteClass"
                            data-url="{{ route('student.class.destroy', $class->id) }}"
                            onclick="openModal(this)">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>

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
    <!-- /.content -->

  </div>
  
</div>
@endsection