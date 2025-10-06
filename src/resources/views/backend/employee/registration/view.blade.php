@extends('admin.main')
@section('admin')

<section
    class="content"
    x-data="employee()"
    x-init="loadEmployees()">

    <div class="row">
        <div class="col-12">
            <div class="box border">
                <div class="box-header">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-3">

                        <div class="flex flex-col gap-3">
                            <h2 class="box-title">Employee Management</h2>
                            <p>Complete directory of school staff</p>
                        </div>

                        <button
                            class="btn btn-default btn-icon pull-right"
                            @click="$refs.employeeDialog.showModal()">
                            <svg class="h-4 w-4 dark-text-foreground">
                                <use href="{{ asset('assets/icons/icons.svg#lucide-plus') }}"></use>
                            </svg>
                            New employee
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="container py-8">

        <div class="mb-6 flex flex-col md:flex-row gap-4">
            {{-- Search --}}
            <div class="relative flex-1">
                <svg class="lens-left">
                    <use href="{{ asset('assets/icons/icons.svg#lucide-search-icon') }}"></use>
                </svg>
                <input
                    x-model.debounce.300ms="searchTerm"
                    @input="loadEmployees(1)"
                    placeholder="Search employees..."
                    class="search-with-lens-left" />
            </div>
            {{-- Select Gender --}}
            <div
                x-on:click.away="openGender = false"
                class="relative">
                <button
                    type="button"
                    x-on:click="openGender = !openGender"
                    class="select-trigger"
                    :aria-expanded="openGender">

                    <svg  class="h-4 w-4 mr-2">
                    <use href="{{ asset('assets/icons/icons.svg#lucide-filter') }}"></use>
                    </svg>

                    <span x-text="getGenderText('Gender')"></span>

                    <svg  class="h-4 w-4 opacity-50" >
                        <use href="{{ asset('assets/icons/icons.svg#lucide-chevron-down') }}"></use>
                    </svg>
                </button>
                {{--Dropdown (SelectContent + SelectItem)  --}}
                <div
                    x-show="openGender"
                    x-transition
                    class="select-content"
                >
                    <ul class="py-1">
                    <template x-for="option in GenderOptions" :key="option.value">
                        <li>
                        <button
                            type="button"
                            x-on:click="selectGender(option.value)"
                            class="select-item"

                        >
                            <span x-text="option.label"></span>
                            <span x-show="selectedGender === option.value" class="select-item-indicator">
                                <svg class="w-4 h-4">
                                    <use href="{{ asset('assets/icons/icons.svg#lucide-check') }}"></use>
                                </svg>
                            </span>
                        </button>
                        </li>
                    </template>
                    </ul>
                </div>
            </div>

        </div>

        <div class="mb-6 flex items-center justify-between">
            @include('components.ui.alpine.pagination-info')
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('backend.employee.registration.partials.employee-card-alpine')
        </div>
        <div>
            @include('components.ui.alpine.pagination')
        </div>
    </main>

    @include('backend.employee.registration.partials.employee-form-alpine')
</section>
@endsection
