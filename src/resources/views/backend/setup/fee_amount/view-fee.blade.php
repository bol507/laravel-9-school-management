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
                
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('fee.amount.view')"
                      :docs="$docs" />
                    <x-ui.search :action="route('fee.amount.view')" />
                  </div>
                  <x-ui.data-table
                    :items="$docs"
                    :columns="[
                      'feeCategory.name' => 'fee Category',
                      'total_amount' =>'total amount',
                    ]"
                    :actions="[
                      'Edit' => fn($doc) => [
                        'href' => route('fee.amount.edit',$doc->fee_category_id),
                        'class' => 'btn-info',  
                      ],
                      'Delete' => fn($doc) => [
                        'href' => 'javascript:void(0);',
                        'class' => 'btn-danger',
                        'attrs' => [
                          'data-modal-confirm' => 'deleteFeeAmount',
                          'data-url' => route('fee.amount.destroy',$doc->fee_category_id),
                          
                        ],  
                      ]  
                    ] "
                  />

                  <div class="row justify-between">
                    <x-ui.pagination-info :docs="$docs" class="text-muted" />
                    <x-ui.paginator :docs="$docs" />
                  </div>

                   
              </div>
               <!-- table-responsive -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <x-ui.dialog
        id="deleteFeeAmount"
        method="DELETE"
        submitText="Delete"
        title="Delete fee amount"
        message="Are you sure you want to delete this fee?" />
    </section>
    <!-- /.content -->

  </div>
  <!-- container-full -->                   

</div>
@endsection