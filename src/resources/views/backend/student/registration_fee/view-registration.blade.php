@extends('admin.main')
@section('admin')
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Student <strong>registration fee</strong></h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="container-fluid">
                  <div class="row justify-between">
                    <x-ui.show-entries
                      :action="route('registration.fee.view')"
                      :docs="$docs->students" />
                    <form class="flex items-center gap-4" method="GET" action="{{ route('registration.fee.view') }}" id="searchForm">

                      <div class="flex items-center py-2">
                        <span class="mr-2">Class</span>
                        <div class="controls">
                          <select name="year_id" required class="form-control">
                            <option value="" disabled selected>Select year</option>
                            @foreach($docs->years as $year)
                            <option value="{{ $year->id }}" @selected(request('year_id')==$year->id)>
                              {{ $year->name }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="flex items-center py-2">
                        <span class="mr-2">Class</span>
                        <div class="controls">
                          <select name="class_id"  class="form-select appearence-none">
                            <option value="" disabled selected>Select class</option>
                            @foreach($docs->classes as $class)
                            <option value="{{ $class->id }}" @selected(request('class_id')==$class->id)>
                              {{ $class->name }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <input type="submit"  class="btn btn-primary" value="Filter">

                    </form>

                    <x-ui.search :action="route('registration.fee.view')" :search="$docs->search"/>
                  </div>

                  @if($docs->students->isEmpty())
                    <p>No students found for the selected criteria.</p>
                  @else

                  <x-ui.data-table
                    class="table-bordered table-striped my-2"
                    :items="$docs->students"
                    :columns="[
                      'profile.id_no' => 'Student no',
                      'user.name' => 'Name',
                      'registration_fee_amount' => 'Registration fee',
                      'total_discount_formatted' => 'Discount',
                      'registration_fee' => 'Fee to pay',

                    ]"
                    :actions="[

                      'Slip fee' => function ($doc) {
                        return [
                          'href'  => route('registration.fee.payslip', [
                            'student_id' => $doc->student_id,
                            'class_id' =>  $doc->class_id,
                            ]),
                          'class' => 'btn-primary',
                          'attrs' => ['target' => '_blank'],
                        ];
                      },
                    ] " />

                    @endif
                  <div class="row items-center justify-between">
                    <x-ui.pagination-info :docs="$docs->students" class="text-muted" />
                    <x-ui.paginator :docs="$docs->students" />
                  </div>

                </div>
              </div><!-- table-responsive -->
            </div> <!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->

    </section>
@endsection
