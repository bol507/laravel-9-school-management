<div class="space-y-6">
    <div class="box">
        <div class="box-header">
            <div class="flex items-center leading-none gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history h-5 w-5 text-primary">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                    <path d="M3 3v5h5"></path>
                    <path d="M12 7v5l4 2"></path>
                </svg>
                <h3>History of salary changes</h3>
            </div>
            <div class="text-md">Complete raise record for <span x-text="selectedEmployee.name"></span></div>
        </div>

        <div class="box-body">

            <template x-if="!selectedEmployee || !selectedEmployee.salaryChanges || selectedEmployee.salaryChanges.length === 0">
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history h-12 w-12 text-muted-foreground/50 mb-4">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                        <path d="M3 3v5h5"></path>
                        <path d="M12 7v5l4 2"></path>
                    </svg>
                    <p>There is no salary change history for this employee.</p>
                </div>
            </template>


            <template x-if="selectedEmployee && selectedEmployee.salaryChanges && selectedEmployee.salaryChanges.length > 0">
                <div class="space-y-4">
                    <template x-for="(change, index) in selectedEmployee.salaryChanges" :key="change.id">
                        <div class="vertical-line">
                            <div class="dot bg-blue-500"></div>

                            <div class="space-y-3">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <!-- Badge: Increase #N -->
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-sm font-medium bg-secondary text-secondary-foreground">
                                                Increase #<span x-text="selectedEmployee.salaryChanges.length - index"></span>
                                            </span>
                                            <span class="text-sm text-muted-foreground flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-3 w-3">
                                                    <path d="M8 2v4"></path>
                                                    <path d="M16 2v4"></path>
                                                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                                    <path d="M3 10h18"></path>
                                                </svg>
                                                <span x-text="formatDate(change.effectiveDate)"></span>
                                            </span>
                                        </div>
                                        <p class="text-sm text-muted-foreground">
                                            Registered on <span x-text="formatDate(change.createdAt)"></span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2 bg-[#008b52]/10 px-3 py-1.5 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up h-4 w-4 text-[#008b52]">
                                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                            <polyline points="16 7 22 7 22 13"></polyline>
                                        </svg>
                                        <span class="text-md font-semibold text-[#008b52]">
                                            +<span x-text="calculatePercentage(change.incrementSalary, change.previousSalary)"></span>%
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-4 p-4 bg-muted/50 rounded-lg">
                                    <div>
                                        <p class="text-sm text-muted-foreground mb-1">Previous Salary</p>
                                        <p class="text-md font-medium text-foreground" x-text="formatCurrency(change.previousSalary)"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-muted-foreground mb-1">Increase</p>
                                        <p class="text-md font-semibold text-[#008b52]">+<span x-text="formatCurrency(change.incrementSalary)"></span></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-muted-foreground mb-1">New Salary</p>
                                        <p class="text-md font-semibold text-foreground" x-text="formatCurrency(change.presentSalary)"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>