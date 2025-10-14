<dialog
    x-ref="leaveDialog"
    @close="closeLeaveDialog()">

    <div
        class="dialog">
        <div class="dialog-header">
            <h2 class="dialog-title">
                Permits of <span x-text="selectedEmployee?.name"></span>
            </h2>

        </div>

        <div class="dialog-body">
            <template x-if="isLoading">
                <p>Loading permissions...</p>
            </template>

            <template x-if="!isLoading && leaves.length === 0">
                <p class="foreground">There are no registered permits.</p>
            </template>

            <div class="space-y-3" x-show="!isLoading">
                <template x-for="leave in leaves" :key="leave.id">
                    <div class="border rounded p-3">
                        <div class="flex justify-between items-center">
                            <span class="font-medium foreground" x-text="leave.type"></span>
                            <span
                                :class="{
                                    'px-2 py-1 rounded-full': true,
                                    'bg-green-100 text-green-800': leave.status === 'approved',
                                    'bg-yellow-100 text-yellow-800': leave.status === 'pending',
                                    'bg-red-100 text-red-800': leave.status === 'rejected',
                                    'bg-gray-100 text-gray-800': !['approved','pending','rejected'].includes(leave.status)
                                }"
                                x-text="leave.status">
                            </span>
                        </div>
                        <p class="text-sm foreground" x-text="leave.dateStart + ' – ' + leave.dateEnd"></p>
                        <p class="foreground" x-show="leave.reason" x-text="leave.reason"></p>
                    </div>
                </template>
            </div>

            {{-- Form --}}
            <div class="border-t pt-4 mt-4">
                <h3 class="text-xl mb-3">Add New Leave</h3>

                {{--leave type --}}
                <div class="mb-3">
                    <label>Leave type</label>
                    <div
                        x-on:click.away="openType = false"
                        class="relative">
                        <button
                            type="button"
                            x-on:click="openType = !openType"
                            class="select-trigger "
                            :aria-expanded="openType">

                            <span x-text="getTypeText('Select type')"></span>

                            <svg class="h-4 w-4 opacity-50">
                                <use href="{{ asset('assets/icons/icons.svg#lucide-chevron-down') }}"></use>
                            </svg>

                        </button>
                        {{--Dropdown (SelectContent + SelectItem)  --}}
                        <div
                            x-show="openType"
                            x-transition
                            class="select-content">
                            <ul class="py-1">
                                <template x-for="option in TypeOptions" :key="option.value">
                                    <li>
                                        <button
                                            type="button"
                                            x-on:click="selectType(option.value)"
                                            class="select-item">
                                            <span x-text="option.label"></span>
                                            <span x-show="selectedType === option.value" class="select-item-indicator">
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

                <!-- Fechas -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Date</label>
                        <input
                            type="date"
                            x-model="leaveForm.date_start"
                            class="input-glass"
                            :class="formErrors.date_start ? 'border-destructive' : ''" />
                        <p x-show="formErrors.date_start" class="text-destructive text-sm mt-1" x-text="formErrors.date_start"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">End Date</label>
                        <input
                            type="date"
                            x-model="leaveForm.date_end"
                            class="input-glass"
                            :class="formErrors.date_end ? 'border-destructive' : ''" />
                        <p x-show="formErrors.date_end" class="text-destructive text-sm mt-1" x-text="formErrors.date_end"></p>
                    </div>
                </div>

                <!-- Reason -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Reason (Optional)</label>
                    <textarea
                        x-model="leaveForm.reason"
                        class="input-glass"
                        rows="2"
                        placeholder="E.g., Medical appointment, Family event..."></textarea>
                </div>

                <!-- Botón de envío -->
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="btn btn-outline"
                        @click="$refs.leaveDialog.close()">
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        :disabled="isSubmitting"
                        @click="submitLeaveForm()">
                        <template x-if="!isSubmitting" >
                            <span>Add Leave</span>
                        </template>
                        <template x-if="isSubmitting">
                            <span>Saving...</span>
                        </template>
                    </button>
                </div>
            </div>
        </div> <!-- dialog-body -->


        <button
            type="button"
            class="dialog-close"
            @click="$refs.leaveDialog.close()">
            <svg class="w-4 h-4">
                <use href="{{ asset('assets/icons/icons.svg#lucide-x') }}"></use>
            </svg>
            <span class="sr-only">Close</span>
        </button>
    </div>
</dialog>
