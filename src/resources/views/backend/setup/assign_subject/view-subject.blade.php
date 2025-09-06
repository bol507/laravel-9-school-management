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
              <h3 class="box-title">Assign subject list</h3>
              <a
                href="{{route('assign.subject.add')}}"
                class="btn btn-success pull-right">
                Add assign subject
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">

                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('assign.subject.view')"
                      :docs="$docs" />
                    <x-ui.search :action="route('assign.subject.view')" />
                  </div>
                  
                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs"
                    :columns="[
                      'studentClass.name' => 'Class name',
                    ]"
                    :actions="[
                      'Edit' => fn($doc) => [
                        'href' => route('assign.subject.edit',$doc->class_id),
                        'class' => 'btn-secondary',  
                      ],
                      'Details' => fn($doc) => [
                        'href' => route('assign.subject.details',$doc->class_id),
                        'class' => 'btn-info',  
                      ]  
                    ] "
                  />
                  <div class="row items-center justify-between">
                    <x-ui.pagination-info :docs="$docs" class="text-muted" />
                    <x-ui.paginator :docs="$docs" />
                  </div>
                </div> <!-- container-fluid -->         
              </div><!-- table-responsive -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section><!-- /.content -->
  </div><!-- container-full -->                   
</div>
@endsection