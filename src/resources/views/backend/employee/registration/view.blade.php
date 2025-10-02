@extends('admin.main')
@section('admin')

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Employee list</h3>
                    <a
                        href="{{route('employee.registration.add')}}"
                        class="btn btn-success pull-right">
                        Add employee
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <div class="row justify-between">
                                <x-ui.show-entries
                                    :action="route('employee.registration.view')"
                                    :docs="$docs->employees" />
                                <x-ui.search :action="route('employee.registration.view')" />
                            </div>
                            @if($docs->employees->isEmpty())
                            <p>No employees found for the selected criteria.</p>
                            @else
                            @php

                            $columns = [
                            'name' => 'Name',
                            'idNo' => 'Id No',
                            'mobile' => 'Mobile',
                            'gender' => 'Gender',
                            'dateJoin' => fn($dto) => $dto->getDateJoinForInput(),
                            'salary' => 'Salary',
                            ];



                            if (auth()->check() && auth()->user()->user_type === 'Admin') {
                            $columns['code'] = 'Code';
                            }
                            @endphp
                            <x-ui.data-table
                                class="table-bordered table-striped my-2"
                                :items="$docs->employees"
                                :columns="$columns"
                                :actions="[
                                            'Edit' => fn($doc) => [
                                                'href' => route('employee.registration.edit',$doc->id),
                                                'class' => 'btn-info',
                                            ],
                                            'Delete' => fn($doc) => [
                                                'href' => 'javascript:void(0);',
                                                'class' => 'btn-danger',
                                                'attrs' => [
                                                'data-modal-confirm' => 'deleteEmployee',
                                                'data-url' => route('designation.destroy',$doc->id),

                                                ],
                                            ]
                                            ] " />
                            @endif
                            <div class="row items-center justify-between">
                                <x-ui.pagination-info :docs="$docs->employees" class="text-muted" />
                                <x-ui.paginator :docs="$docs->employees" />
                            </div>

                        </div>
                    </div><!-- table-responsive -->
                </div> <!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <x-ui.dialog
        id="deleteEmployee"
        method="DELETE"
        submitText="Delete"
        title="Delete employee"
        message="Are you sure you want to delete this employee?" />
</section>
@endsection