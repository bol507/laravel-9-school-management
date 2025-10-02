<div class="box">
    <div class="box-header">
        <h3 class="box-title">Employees</h3>
        <div class="relative mt-4">
            <svg class="lens-left">
               <use href="{{ asset('assets/icons/icons.svg#lucide-search-icon') }}"></use>
            </svg>
            <input
                x-model.debounce.300ms="searchTerm"
                @input="loadEmployees(1)"
                placeholder="Search employees..."
                class="search-with-lens-left"
            />
        </div>
    </div>
    <div class="box-body">
        <div class="overflow-y-auto max-h-[480px]">
            <template x-for="employee in employees" :key="employee.id">
                <button 
                    type="button"
                    class="button-employee"
                    @click="selectEmployee(employee)"
                >
                    <div class="flex items-center gap-3 w-full">
                        <span class="relative flex size-8 shrink-0 overflow-hidden rounded-full h-10 w-10">
                            <span class="flex size-full items-center justify-center rounded-full bg-blue-500 text-white">
                                <span x-text="getInitials(employee.name)"></span>
                            </span>
                        </span>
                        <div class="flex-1 text-left space-y-1">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-sm" x-text="employee.name"></p>
                                <span class="badge badge-primary text-xs" x-text="employee.idNo"></span>
                            </div>
                            <p class="text-sm text-muted-foreground" x-text="employee.designationName"></p>
                            <p class="text-md font-semibold text-accent" x-text="formatCurrency(employee.salary)"></p>
                        </div>
                    </div>
                </button>
            </template>
        </div>
        <div class="flex items-center justify-between px-4 py-3 ">
            @include('backend.employee.salary.partials.pagination-info-alpine')
            @include('backend.employee.salary.partials.pagination-alpine')
        </div>
    </div>
</div>