@extends('admin.main')
@section('admin')

<section class="content">

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="flex items-center justify-between">
                        
                        <div class="flex flex-col gap-3">
                            <h2 class="box-title">Employee Management</h2>
                            <p>Complete directory of school staff</p>
                        </div>
                        
                        <button class="btn btn-default btn-icon pull-right">
                            <svg class="h-6 w-6 dark-text-foreground">
                                <use href="{{ asset('assets/icons/icons.svg#lucide-plus') }}"></use>
                            </svg>
                            New employee
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <main class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          
        </div>
    </main>
    
    <x-ui.dialog
        id="deleteEmployee"
        method="DELETE"
        submitText="Delete"
        title="Delete employee"
        message="Are you sure you want to delete this employee?" />
</section>
@endsection