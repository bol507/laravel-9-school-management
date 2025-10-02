<div class="box">
    <div class="box-header">
        <h3 class="box-title">Employees</h3>
        <div class="relative mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search lens-left">
                <path d="m21 21-4.34-4.34" />
                <circle cx="11" cy="11" r="8" />
            </svg>
            <input
                placeholder="Find employee..."
                value="{{ old('search', $search ?? '') }}"
                class="search-with-lens-left"
            />
        </div>
    </div>
    <div class="box-body">
        <div class="overflow-y-auto max-h-[400px]">
            @foreach($employees as $employee)
                <button type="button"
                    class="button-employee"
                    
                    @click="selectEmployee({{ json_encode([
                        'id' => $employee->id,
                        'name' => $employee->name,
                        'designationName' => $employee->designationName,
                        'salary' => $employee->formattedSalary(),
                        'presentSalary' => $employee->salary,
                    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }})"
                >
                    <div class="flex items-center gap-3 w-full">
                        <span class="relative flex size-8 shrink-0 overflow-hidden rounded-full h-10 w-10">
                            <span class="flex size-full items-center justify-center rounded-full bg-blue-500 text-white">
                                @php
                                    $words = explode(' ', trim($employee->name));
                                    $initials = '';
                                    foreach ($words as $word) {
                                        if ($word !== '') {
                                            $initials .= strtoupper(substr($word, 0, 1));
                                        }
                                    }
                                    echo substr($initials, 0, 2);
                                @endphp
                            </span>
                        </span>
                        <div class="flex-1 text-left space-y-1">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-sm text-foreground">{{ $employee->name }}</p>
                                <span class="badge badge-primary">{{ $employee->idNo }}</span>
                            </div>
                            <p class="text-sm text-muted-foreground">{{ $employee->designationName }}</p>
                            <p class="text-md font-semibold text-accent">{{ $employee->formattedSalary() }}</p>
                        </div>
                    </div>
                </button>
            @endforeach
        </div>
        <div class="flex items-center justify-between px-4 py-3 border-t border-borde">
            <x-ui.pagination-info :docs="$employees" class="text-muted" />
            <x-ui.paginator :docs="$employees" />
        </div>
    </div>
</div>
