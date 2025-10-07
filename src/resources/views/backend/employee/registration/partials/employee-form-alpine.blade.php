<dialog
    x-ref="employeeDialog"
    closedby="any">
    <div class="dialog">
        <div class="dialog-header">
            <h2 class="dialog-title ">Create new employee</h2>
        </div>
        <form>
            {{-- Personal Information --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-foreground">Personal information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="name">Name</label>
                        <input
                            name="name"
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        <label for="father_name">Father's name</label>
                        <input
                            name="father_name"
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        <label for="mother_name">Mother's name</label>
                        <input
                            name="mother_name"
                            class="input-glass">
                    </div>
                </div> <!-- grid -->

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="mobile">Mobile</label>
                        <input
                            name="mobile"
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        <label for="address">Address</label>
                        <input
                            name="address"
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
                            class="input-glass">
                    </div>
                    <div class="space-y-2">
                        <label for="date_birth">Date of birth</label>
                        <div class="relative flex-1">
                            <input
                                type="date"
                                name="date_birth"
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
                            name="salary"
                            class="input-glass">
                    </div><!-- space-y-2 -->
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="image">Image</label>

                    <input
                        id="image"
                        type="file"
                        name="image"
                        class="input-glass">



                    <picture>
                        <img
                            id="show-image"
                            src="{{ (!empty($docs->profile_data->image) ? url('upload/user_images/'.$docs->profile_data->image ) : url('upload/no_image.jpg')) }}"
                            alt="User Avatar"
                            style="width:100px; height:100px; border:1px solid #ddd">
                    </picture>
                    </div>




                </div>
            </div> <!-- space-y-4 -->
        </form>
    </div>
</dialog>
