<dialog
    x-ref="leaveDialog"
    @close="closeLeaveDialog()">

        <div
            class="dialog"
            >
            <div class="dialog-header">
                <h2 class="dialog-title">
                    Permits of <span x-text="selectedEmployee?.name"></span>
                </h2>

            </div>

            <div class="dialog-body">
                <template x-if="isLoading">
                    <p>Cargando permisos...</p>
                </template>

                <template x-if="!isLoading && leaves.length === 0">
                    <p class="text-muted">No hay permisos registrados.</p>
                </template>

                <div class="space-y-3" x-show="!isLoading">
                    <template x-for="leave in leaves" :key="leave.id">
                        <div class="border rounded p-3">
                            <div class="flex justify-between items-center">
                                <span class="font-medium" x-text="leave.type.name"></span>
                                <span
                                    :class="`px-2 py-1 rounded-full text-xs bg-${getStatusColor(leave.status.code)}-100 text-${getStatusColor(leave.status.code)}-800`"
                                    x-text="leave.status.name">
                                </span>
                            </div>
                            <p class="text-sm text-muted" x-text="leave.startDate + ' – ' + leave.endDate"></p>
                            <p x-show="leave.reason" x-text="leave.reason"></p>
                        </div>
                    </template>
                </div>
            </div>


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

