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
              <h3 class="box-title">Designation list</h3>
              <a
                href="{{route('designation.add')}}"
                class="btn btn-success pull-right">
                Add designation
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('designation.view')"
                      :docs="$docs" />
                    <x-ui.search :action="route('designation.view')" />
                  </div>
                  
                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs"
                    :columns="[
                      'name' => 'name',
                    ]"
                    :actions="[
                      'Edit' => fn($doc) => [
                        'href' => route('designation.edit',$doc),
                        'class' => 'btn-info',  
                      ],
                      'Delete' => fn($doc) => [
                        'href' => 'javascript:void(0);',
                        'class' => 'btn-danger',
                        'attrs' => [
                          'data-modal-confirm' => 'deleteDesignation',
                          'data-url' => route('designation.destroy',$doc),
                          
                        ],  
                      ]  
                    ] "
                  />

                  <div class="row items-center justify-between">
                    <x-ui.pagination-info :docs="$docs" class="text-muted" />
                    <x-ui.paginator :docs="$docs" />
                  </div>

                </div>   
              </div><!-- table-responsive -->
            </div> <!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
      <x-ui.dialog
        id="deleteDesignation"
        method="DELETE"
        submitText="Delete"
        title="Delete designation"
        message="Are you sure you want to delete this designation?" />
    </section>
  </div><!-- container-full -->        
</div>
@endsection