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
                    @include('components.pagination.show-entries')
                    @include('components.pagination.search')
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
                            data-url="{{ route('student.class.destroy', $class->id) }}"
                            data-title="Delete student class"
                            data-message="Are you sure you want to delete this class?"
                            onclick="openModal(this)">Delete</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>

                  <div class="row">
                    @include('components.pagination.showing')
                    @include('components.pagination.paginator')
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
    </section>
    <!-- /.content -->

  </div>
  @include('backend.setup.student_class.partials.modal')
  <script>
    

    document.addEventListener('DOMContentLoaded', function() {
      const dialog = document.querySelector('dialog');
      const modalInstance = new bootstrap.Modal(dialog);

      window.openModal = function(element) {
        const url = element.getAttribute('data-url');
        const title = element.getAttribute('data-title') 
        const message = element.getAttribute('data-message')

        
        document.getElementById('deleteUserForm').action = url;
        dialog.querySelector('.modal-title').textContent = title;
        dialog.querySelector('.modal-body p').textContent = message;

        modalInstance.show();
      };

      window.closeModal = function(event) {
        if (event) {
          event.preventDefault();
        }
        modalInstance.hide();
        //dialog.close();
        return false;
      };

      dialog.addEventListener('click', function(event) {
        if (event.target === dialog) {
          closeModal();
        }
      });
    });
  </script>
</div>
@endsection