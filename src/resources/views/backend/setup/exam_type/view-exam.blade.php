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
              <h3 class="box-title">Exam type list</h3>
              <a
                href="{{route('exam.type.add')}}"
                class="btn btn-success pull-right">
                Add exam type
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('exam.type.view')"
                      :docs="$docs" />
                    <x-ui.search :action="route('exam.type.view')" />
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
                        'href' => route('exam.type.edit',$doc),
                        'class' => 'btn-info',  
                      ],
                      'Delete' => fn($doc) => [
                        'href' => 'javascript:void(0);',
                        'class' => 'btn-danger',
                        'attrs' => [
                          'data-modal-confirm' => 'deleteExamType',
                          'data-url' => route('exam.type.destroy',$doc),
                          
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
        id="deleteExamType"
        method="DELETE"
        submitText="Delete"
        title="Delete exam type"
        message="Are you sure you want to delete this exam type?" />
    </section>
  </div><!-- container-full -->        
</div>
@endsection