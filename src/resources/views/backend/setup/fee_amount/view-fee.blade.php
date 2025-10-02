@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Student fee amount list</h3>
              <a
                href="{{route('fee.amount.add')}}"
                class="btn btn-success pull-right">
                Add fee amount
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">

                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('fee.amount.view')"
                      :docs="$docs" />
                    <x-ui.search :action="route('fee.amount.view')" />
                  </div>
                  
                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs"
                    :columns="[
                      'feeCategory.name' => 'fee Category',
                      'total_amount' =>'total amount',
                    ]"
                    :actions="[
                      'Edit' => fn($doc) => [
                        'href' => route('fee.amount.edit',$doc->fee_category_id),
                        'class' => 'btn-secondary',  
                      ],
                      'Details' => fn($doc) => [
                        'href' => route('fee.amount.details',$doc->fee_category_id),
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
    </section>
@endsection