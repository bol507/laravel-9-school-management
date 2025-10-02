@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Student fee category list</h3>
              <a
                href="{{route('fee.category.add')}}"
                class="btn btn-success pull-right">
                Add fee category
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('fee.category.view')"
                      :docs="$docs" />
                    <x-ui.search :action="route('fee.category.view')" />
                  </div>
                  
                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs"
                    :columns="[
                      'name' => 'name',
                      'description' => 'description',
                    ]"
                    :actions="[
                      'Edit' => fn($doc) => [
                        'href' => route('fee.category.edit',$doc),
                        'class' => 'btn-info',  
                      ],
                      'Delete' => fn($doc) => [
                        'href' => 'javascript:void(0);',
                        'class' => 'btn-danger',
                        'attrs' => [
                          'data-modal-confirm' => 'deleteFeeCategory',
                          'data-url' => route('fee.category.destroy',$doc),
                          
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
        id="deleteFeeCategory"
        method="DELETE"
        submitText="Delete"
        title="Delete fee category"
        message="Are you sure you want to delete this fee category?"
      />
    </section>
@endsection