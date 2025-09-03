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
              <h3 class="box-title">Fee amount details</h3>
              <a
                href="{{route('fee.amount.add')}}"
                class="btn btn-success pull-right">
                Add fee amount
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
                <h4><strong>Fee category: </strong>{{ $doc[0]['feeCategory']['name'] }}</h4>
              <div class="table-responsive">
                <div class="container-fluid">
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('fee.amount.view')"
                      :docs="$doc" />
                    <x-ui.search :action="route('fee.amount.view')" />
                  </div>
                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$doc"
                    :columns="[
                      'studentClass.name' => 'Class name',
                      'amount' =>'Amount',
                    ]"
                    
                  />
                  <div class="row justify-between">
                    <x-ui.pagination-info :docs="$doc" class="text-muted" />
                    <x-ui.paginator :docs="$doc" />
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