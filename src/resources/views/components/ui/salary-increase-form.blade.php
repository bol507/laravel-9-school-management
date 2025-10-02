
    <div class="space-y-6">
        <div class="box">
            <div class="box-header">
                <div class="flex items-center leading-none gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up h-5 w-5 text-accent">
                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                        <polyline points="16 7 22 7 22 13"></polyline>
                    </svg>
                    <h3 class="box-title">Process Salary Increase</h3>
                </div>
                <div class="text-muted-foreground text-md">
                    Employee: <span class="font-medium text-foreground" x-text="selectedEmployee.name"></span> •
                    <span x-text="selectedEmployee.designationName"></span>
                </div>
            </div>
            <div class="box-body">
                <form
                    class="space-y-6"
                    @submit.prevent="submitSalaryIncrease()"
                    x-ref="salaryForm"
                >
                @csrf
                    <div class="row">
                        <div class="space-y-2 col-6">
                            <label class="control-label" for="present_salary">Present salary</label>
                            <input
                                class="form-control"
                                id="present-salary"
                                name="present_salary"
                                disabled
                                x-model="selectedEmployee.presentSalary"
                            >
                        </div>
                        <div class="space-y-2 col-6">
                            <label class="control-label" for="new-salary">New salary</label>
                            <input
                                class="form-control"
                                id="new-salary"
                                disabled
                                x-model="newSalary"
                            >
                        </div>
                    </div>

                    <div class="row">
                        <div class="space-y-2 col-6">
                            <label class="control-label" for="increment-salary">Increment</label>
                            <input
                                class="form-control"
                                id="increment-salary"
                                step="0.01"
                                placeholder="0.00"
                                type="number"
                                x-model.number="incrementAmount"
                                @input="calculateNewSalary()"
                            >
                        </div>
                        <div class="space-y-2 col-6">
                            <label class="control-label" for="increment-percentage">Percentage increment</label>
                            <input
                                class="form-control"
                                id="increment-percentage"
                                step="0.01"
                                placeholder="0.00"
                                type="number"
                                x-model.number="incrementPercentage"
                                @input="calculateNewSalaryFromPercentage()"
                            >
                        </div>
                    </div>

                    <div class="row">
                        <div class="space-y-2 col-12">
                            <label class="control-label" for="effective-date">Effective date</label>
                            <input
                                type="date"
                                class="form-control date-right"
                                id="effective-date"
                                x-model="effectiveDate"
                                name="effective_date"
                                required
                            >
                        </div>
                    </div>

                    <input type="hidden" name="employee_id" :value="selectedEmployee.id">
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="isSubmitting"
                        >
                            <span x-show="!isSubmitting">Update Salary</span>
                            <span x-show="isSubmitting">Processing...</span>
                        </button>
                    </div>


                </form>
            </div>
        </div>
    </div>

