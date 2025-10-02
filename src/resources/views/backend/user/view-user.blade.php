@extends('admin.main')
@section('admin')
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
                <div class="container-fluid">
                  
                <div class="row justify-between">
                    <x-ui.show-entries 
                      :action="route('user.view')" 
                      :docs="$docs" 
                    />
                    <x-ui.search
                      :action="route('user.view')"
                      :search="$search" 
                    />
                  </div>

                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs"
                    :columns="[
                      'user_type' => 'Role',
                      'name' => 'Name',
                      'email' => 'Email',
                    ]"
                    :actions="[
                      
                      'Edit' => fn($doc) => [
                        'href'  => route('user.edit', $doc),
                        'class' => 'btn-info',
                      ],
                      'Delete' => fn($doc) => [
                          'href'  => 'javascript:void(0);',
                          'class' => 'btn-danger',
                          'attrs' => [
                              'data-modal-confirm' => 'deleteUser',
                              'data-url'           => route('user.destroy', $doc),
                              
                          ],
                      ],
                    
                    ]" />

                  
                    <div class="row items-center justify-between">
                    <x-ui.pagination-info :docs="$docs" class="text-muted" />
                    <x-ui.paginator :docs="$docs" />
                  </div>
                </div><!-- container-fuild -->
              </div> <!-- table-responsive -->
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
      <x-ui.dialog
        id="deleteUser"
        method="DELETE"
        submitText="Delete"
        title="Delete user"
        message="Are you sure you want to delete this user?" />
    </section>
@endsection