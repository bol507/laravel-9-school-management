@extends('admin.main')
@section('admin')
<section class="content"
    x-data="salaryIncrease()">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">Salary increase management</h2>
                    <p>Manage and record your employees' salary increases</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <x-ui.employee-list :employees="$docs->employees" :search="$docs->search ?? ''" />
        </div>
        <template x-if="selectedEmployee">
            <div class="lg:col-span-2">
                <x-ui.salary-increase-form />
                <x-ui.salary-history />
            </div>
        </template>
    </div>

</section>

@endsection