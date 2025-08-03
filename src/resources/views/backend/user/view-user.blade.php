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
              <h3 class="box-title">User list</h3>
              <a href="{{route('user.add')}}" class="btn btn-success pull-right">Add User</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>Role</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($allData as $key => $user)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$user->user_type}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                          <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info">Edit</a>
                          <a 
                            href="javascript:void(0);"  
                            class="btn btn-danger"
                            data-url="{{ route('user.destroy', $user->id) }}"
                            onclick="openModal(this)"
                          >Delete</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    
                  </tfoot>
                </table>
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
  @include('backend.user.partials.modal')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modalEl = document.getElementById('modal-delete');
      const modalInstance = new bootstrap.Modal(modalEl);

      
      window.openModal = function(element) {
          const url = element.getAttribute('data-url');
          document.getElementById('deleteUserForm').action = url; 
          modalInstance.show();
      };

      
      window.closeModal = function(event) {
        if (event) {
          event.preventDefault(); 
        }
        modalInstance.hide(); 
        return false;
      };

    
      modalEl.addEventListener('click', function(event) {
          if (event.target === modalEl) {
              closeModal(); 
          }
      });
  });
  </script>
</div>
@endsection