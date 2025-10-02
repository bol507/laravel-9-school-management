import axios from 'axios';

export default () => ({
    selectedEmployee: null,
    incrementAmount: 0,
    incrementPercentage: 0,
    newSalary: 0,
    effectiveDate: new Date().toISOString().split('T')[0],
    isSubmitting: false,
    successMessage: null,
    errorMessage: null,

    init() {
        console.log('Salary increase component initialized');
    },

    selectEmployee(employeeData) {
        this.selectedEmployee = employeeData;
        this.loadEmployeeSalaryHistory(employeeData.id);
    },

    calculateNewSalary() {
        if (!this.selectedEmployee) return;
        const base = parseFloat(this.selectedEmployee.presentSalary);
        const inc = parseFloat(this.incrementAmount) || 0;
        this.newSalary = (base + inc).toFixed(2);
        this.incrementPercentage = base ? ((inc / base) * 100).toFixed(2) : 0;
    },

    calculateNewSalaryFromPercentage() {
        if (!this.selectedEmployee) return;
        const base = parseFloat(this.selectedEmployee.presentSalary);
        const pct = parseFloat(this.incrementPercentage) || 0;
        this.incrementAmount = base ? ((base * pct) / 100).toFixed(2) : 0;
        this.newSalary = (base + parseFloat(this.incrementAmount)).toFixed(2);
    },

    async submitSalaryIncrease() {
        if (!this.selectedEmployee) {
            this.errorMessage = 'No employee selected.';
            return;
        }

        this.isSubmitting = true;
        this.successMessage = null;
        this.errorMessage = null;

        try {
            const response = await axios.put(
                `/employees/salary/update/${this.selectedEmployee.id}`,
                {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    increment_amount: this.incrementAmount,
                    increment_percentage: this.incrementPercentage,
                    new_salary: this.newSalary,
                    effective_date: this.effectiveDate
                }
            );

            this.successMessage = 'Salary updated successfully!';

            // form reset
            this.incrementAmount = 0;
            this.incrementPercentage = 0;
            this.effectiveDate = new Date().toISOString().split('T')[0];
            //
            this.selectedEmployee.presentSalary = this.newSalary;
            //loadHistory
            this.loadEmployeeSalaryHistory(this.selectedEmployee.id)

        } catch (error) {
            this.errorMessage = error.response?.data?.message || 'An error occurred while updating the salary.';
            console.error(error);
        } finally {
            this.isSubmitting = false;
        }
    },

    async loadEmployeeSalaryHistory(employeeId) {
        if (!employeeId) return;

            try {
                const { data } = await axios.get(`/employees/salary/history/${employeeId}`);
                this.selectedEmployee = {
                    ...this.selectedEmployee,
                    salaryChanges: data
                };
                console.log(this.selectedEmployee);
                this.message = '';
            } catch (err) {
                console.error(err);
                this.message = 'The history could not be loaded.';
            }
    },

    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      });
    },

    formatCurrency(amount) {
      return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'USD' // o 'PEN', 'MXN', etc.
      }).format(amount);
    },

    calculatePercentage(increment, previous) {
      if (!previous || previous <= 0) return 0;
      return ((increment / previous) * 100).toFixed(2);
    }
});
