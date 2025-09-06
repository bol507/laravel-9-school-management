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
              <h3 class="box-title">School Subject list</h3>
              <a
                href="{{route('school.subject.add')}}"
                class="btn btn-success pull-right">
                Add school subject
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('school.subject.view')"
                      :docs="$docs" />
                    <x-ui.search :action="route('school.subject.view')" />
                  </div>
                  
                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs"
                    :columns="[
                      'name' => 'name',
                    ]"
                    :actions="[
                      'Edit' => fn($doc) => [
                        'href' => route('school.subject.edit',$doc),
                        'class' => 'btn-info',  
                      ],
                      'Delete' => fn($doc) => [
                        'href' => 'javascript:void(0);',
                        'class' => 'btn-danger',
                        'attrs' => [
                          'data-modal-confirm' => 'deleteSchoolSubject',
                          'data-url' => route('school.subject.destroy',$doc),
                          
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
        id="deleteSchoolSubject"
        method="DELETE"
        submitText="Delete"
        title="Delete school subject"
        message="Are you sure you want to delete this school subject?" />
    </section>
  </div><!-- container-full -->        
</div>
@endsection