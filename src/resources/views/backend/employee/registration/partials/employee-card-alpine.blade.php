<template x-for="employee in employees" :key="employee.id">
    <div
        class="box border py-6 gap-6"
        x-show="employee"
        x-cloak>
        <!-- Card Header -->
        <div class="liquid-glass-container">
            <div class="flex items-center gap-4">
                <!-- Avatar -->
                <div class="relative">
                    <img
                        :src="employee.imagePath || '/placeholder.svg'"
                        :alt="employee.name"
                        class="h-16 w-16 rounded-full border-2 border-background object-cover"
                        x-show="employee.imagePath"
                        x-on:error="employee.imagePath = null" />
                    <div
                        class="h-16 w-16 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-lg font-semibold"
                        x-show="!employee.imagePath">
                        <span class="flex size-full items-center justify-center rounded-full bg-blue-500 text-white">
                            <span x-text="getInitials(employee.name)"></span>
                        </span>

                    </div>
                </div>
                <div class="flex flex-col flex-1">
                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-lg text-balance leading-tight" x-text="employee.name"></h3>

                        <template x-if="employee.designationName">
                            <div class="flex items-center gap-1.5 mt-1">
                                <svg class="h-4 w-4">
                                    <use href="{{ asset('assets/icons/icons.svg#lucide-briefcase') }}"></use>
                                </svg>
                                <span class="text-md" x-text="employee.designationName"></span>
                            </div>
                        </template>

                        <template x-if="employee.employeeId">
                            <span class="badge badge-default">
                                ID: <span  x-text="employee.idNo"></span>
                            </span>
                        </template>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-1 shrink-0">
                    <button
                        @click="$dispatch('open-leave-dialog', { employee })"
                        class="h-8 w-8 rounded-md bg-accent flex items-center justify-center"
                        title="Leave">
                        <svg class="h-4 w-4">
                            <use href="{{ asset('assets/icons/icons.svg#lucide-calendar-days') }}"></use>
                        </svg>
                    </button>
                    <button
                        @click="$dispatch('edit-employee', {employee})"
                        class="h-8 w-8 rounded-md bg-accent flex items-center justify-center"
                        title="Edit">
                        <svg  class="h-4 w-4">
                            <use href="{{ asset('assets/icons/icons.svg#lucide-pencil') }}"></use>
                        </svg>
                    </button>
                    <button
                        @click="deleteEmployee()"
                        class="h-8 w-8 rounded-md bg-accent text-destructive flex items-center justify-center"
                        title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                            <path d="M3 6h18" />
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Card Content -->
        <div class="px-6 pt-2 space-y-3">
            <!-- Contact Info -->
            <div class="space-y-2">
                <template x-if="employee.mobile">
                    <div class="flex items-center gap-2 text-md">
                        <svg class="h-4 w-4">
                            <use href="{{ asset('assets/icons/icons.svg#lucide-phone') }}"></use>
                        </svg>
                        <span class="title" x-text="employee.mobile"></span>
                    </div>
                </template>

                <template x-if="employee.address">
                    <div class="flex items-start gap-2 ">
                        <svg class="h-4 w-4">
                            <use href="{{ asset('assets/icons/icons.svg#lucide-map-pin') }}"></use>
                        </svg>
                        <span class="title" x-text="employee.address"></span>
                    </div>
                </template>
            </div>

            <!-- Personal Details -->
            <template x-if="employee.gender || employee.dateBirth">
                <div class="pt-2 border-top space-y-1.5">
                    <template x-if="employee.gender">
                        <div class="flex items-center gap-2 text-md">
                            <svg class="h-4 w-4">
                                <use href="{{ asset('assets/icons/icons.svg#lucide-user') }}"></use>
                            </svg>
                            <span class="text">Gender:</span>
                            <span class="title" x-text="employee.gender"></span>
                        </div>
                    </template>
                    <template x-if="employee.dateBirth">
                        <div class="flex items-center gap-2 text-md ">
                            <svg class="h-4 w-4">
                                <use href="{{ asset('assets/icons/icons.svg#lucide-calendar') }}"></use>
                            </svg>
                            <span class="text">Birth date:</span>
                            <span class="title" x-text="formatDate(employee.dateBirth)"></span>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Employment Info -->
            <template x-if="employee.dateJoin">
                <div class="pt-2 border-top">
                    <div class="flex items-center gap-2 text-md">
                        <svg class="h-4 w-4">
                            <use href="{{ asset('assets/icons/icons.svg#lucide-calendar') }}"></use>
                        </svg>
                        <span class="text">Join date:</span>
                        <span class="font-medium title" x-text="formatDate(employee.dateJoin)"></span>
                    </div>
                </div>
            </template>

            <!-- Salary Info -->
            <template x-if="employee.salary">
                <div class="pt-2 border-top space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-md">
                            <svg class="h-4 w-4">
                                <use href="{{ asset('assets/icons/icons.svg#lucide-dollar') }}"></use>
                            </svg>
                            <span>Present salary:</span>
                        </div>
                        <span class="font-semibold text-lg title" x-text="formatCurrency( employee.salary)"></span>
                    </div>


                </div>
            </template>
        </div>
    </div>
</template>
