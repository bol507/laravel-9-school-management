<dialog
    x-ref="employeeDialog"
    @close="resetForm(); clearGenderForm(); clearDesignationForm()"
    closedby="any">

    <div class="dialog">
        <div class="dialog-header">
            <h2 class="dialog-title ">
                <span x-text="isEditing ? 'Edit Employee' : 'Create New Employee'"></span>
            </h2>
        </div>
        <form  @submit.prevent="saveEmployee">

            <div class="space-y-4">
                {{-- Personal Information --}}
                <h3 class="text-lg font-semibold text-foreground">Personal information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="name">Name</label>
                        <input
                            name="name"
                            x-model="employeeForm.name"
                            class="input-glass"
                            required>
                    </div>
                    <div class="space-y-2">
                        <label for="father_name">Father's name</label>
                        <input
                            name="father_name"
                            x-model="employeeForm.father_name"
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        <label for="mother_name">Mother's name</label>
                        <input
                            name="mother_name"
                            x-model="employeeForm.mother_name"
                            class="input-glass">
                    </div>
                </div> <!-- grid -->

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="mobile">Mobile</label>
                        <input
                            name="mobile"
                            x-model="employeeForm.mobile"
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        <label for="address">Address</label>
                        <input
                            name="address"
                            x-model="employeeForm.address"
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        {{-- Select Gender --}}
                        <label for="gender">Gender</label>
                        <div
                            x-on:click.away="openGenderForm = false"
                            class="relative">
                            <button
                                type="button"
                                x-on:click="openGenderForm = !openGenderForm"
                                class="select-trigger"
                                :aria-expanded="openGenderForm">

                                <span x-text="getGenderFormText('Gender')"></span>

                                <svg class="h-4 w-4 opacity-50">
                                    <use href="{{ asset('assets/icons/icons.svg#lucide-chevron-down') }}"></use>
                                </svg>

                            </button>
                            {{--Dropdown (SelectContent + SelectItem)  --}}
                            <div
                                x-show="openGenderForm"
                                x-transition
                                class="select-content">
                                <ul class="py-1">
                                    <template x-for="option in GenderFormOptions" :key="option.value">
                                        <li>
                                            <button
                                                type="button"
                                                x-on:click="selectGenderForm(option.value)"
                                                class="select-item">
                                                <span x-text="option.label"></span>
                                                <span x-show="selectedGenderForm === option.value" class="select-item-indicator">
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
                </div><!-- grid -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="religion">Religion</label>
                        <input
                            name="religion"
                            x-model="employeeForm.religion"
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        <label for="date_birth">Date of birth</label>
                        <div class="relative flex-1">
                            <input
                                type="date"
                                name="date_birth"
                                x-model="employeeForm.date_birth"
                                class="input-glass pr-10">
                            <svg class="calendar-right h-4 w-4 foreground-dark">
                                <use href="{{ asset('assets/icons/icons.svg#lucide-calendar') }}"></use>
                            </svg>
                        </div>
                    </div>

                </div> <!-- grid -->

                {{-- Employment Information --}}
                <h3 class="text-lg font-semibold text-foreground">Employment information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        {{-- Select Gender --}}
                        <label for="designation-id">Designations</label>
                        <div
                            x-on:click.away="openDesignationForm = false"
                            class="relative">
                            <button
                                type="button"
                                x-on:click="openDesignationForm = !openDesignationForm"
                                class="select-trigger "
                                :aria-expanded="openDesignationForm">

                                <span x-text="getDesignationFormText('Select designation')"></span>

                                <svg class="h-4 w-4 opacity-50">
                                    <use href="{{ asset('assets/icons/icons.svg#lucide-chevron-down') }}"></use>
                                </svg>

                            </button>
                            {{--Dropdown (SelectContent + SelectItem)  --}}
                            <div
                                x-show="openDesignationForm"
                                x-transition
                                class="select-content">
                                <ul class="py-1">
                                    <template x-for="option in DesignationFormOptions" :key="option.value">
                                        <li>
                                            <button
                                                type="button"
                                                x-on:click="selectDesignationForm(option.value)"
                                                class="select-item">
                                                <span x-text="option.label"></span>
                                                <span x-show="selectedDesignationForm === option.value" class="select-item-indicator">
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

                    <div class="space-y-2">
                        <label for="date_join">Join date</label>
                        <div class="relative flex-1">
                            <input
                                type="date"
                                name="date_join"
                                x-model="employeeForm.date_join"
                                class="input-glass pr-10">
                            <svg class="calendar-right h-4 w-4 foreground-dark">
                                <use href="{{ asset('assets/icons/icons.svg#lucide-calendar') }}"></use>
                            </svg>
                        </div>
                    </div><!-- space-y-2 -->
                </div><!-- grid -->

                {{-- Salary Information --}}
                <h3 class="text-lg font-semibold text-foreground">Salary information</h3>
                <div class="grid grid-cols-1  gap-4">
                    <div class="space-y-2">
                        <label for="salary">Salary</label>
                        <input
                            type="number"
                            x-model.number="employeeForm.salary"
                            name="salary"
                            class="input-glass">
                    </div><!-- space-y-2 -->
                </div> <!-- grid -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="image">Image</label>

                        <input
                            id="image"
                            type="file"
                            name="image"
                            @change="previewImage"
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        <picture>
                            <img
                                id="show-image"
                                src="{{ url('upload/no_image.jpg') }}"
                                :src="employeeForm.image
                                    ? URL.createObjectURL(employeeForm.image)
                                    : currentImageUrl || '{{ asset('upload/no_image.jpg') }}'"
                                alt="Preview"
                                style="width:100px; height:100px; border:1px solid #ddd">
                        </picture>
                    </div>




                </div>
            </div> <!-- space-y-4 -->
            <div class="py-4 flex justify-end gap-2">
                <button type="button" @click="$refs.employeeDialog.close()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        <button
            type="button"
            class="dialog-close"
            @click="$refs.employeeDialog.close()">
            <svg class="w-4 h-4">
                <use href="{{ asset('assets/icons/icons.svg#lucide-x') }}"></use>
            </svg>
            <span class="sr-only">Close</span>
        </button>
    </div>
</dialog>
