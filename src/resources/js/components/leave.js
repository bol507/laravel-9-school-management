import axios from "axios";
import paginationComponent from "./pagination";
import createSelect from "../utils/create-select";

export default () => {
    const typeSelect = createSelect('Type', null);
    const statusSelect = createSelect('Status',null);
    return {
        leaves: [],
        leaveTypes: [],
        leaveStatuses: [],
        selectedEmployee: null,
        selectedLeave: null,
        isLoading: false,
        pagination: paginationComponent(6),
        searchTerm: null,
        leaveForm: {
            date_start: '',
            date_end: '',
            reason: '',
        },
        formErrors: {},
        isSubmitting: false,
        ...typeSelect,
        ...statusSelect,

        init() {
            this.setInitialFormValues();
        },

        loadSelects(types,statuses) {
            try {
                const typeOptions =  types.map(d => ({
                    value: d.id,
                    label: d.name
                }));
                const statusOptions = statuses.map(d => ({
                    value: d.id,
                    label: d.name
                }));
                this.leaveStatuses = statuses; //for getColors
                this.initTypeOptions(typeOptions);
                this.initStatusOptions(statusOptions);
            } catch (err) {
                console.error('Error loading selects:', err);
                this.initTypeOptions([]);
                this.initStatusOptions([]);
            }
        },

        setInitialFormValues() {
            const pendingStatus = this.leaveStatuses.find(s => s.code === 'pending');
            this.leaveForm.leave_status_id = pendingStatus ? pendingStatus.id : '';
        },

        async loadLeaves(id) {
            try {

                this.isLoading = true;

                const { data } = await axios.get(`/ajax/leaves/employee/${id}`);

                this.leaves = data.leaves;
                this.pagination.initPagination(data.pagination);
                this.loadSelects(data.types, data.statuses);
            } catch (err) {
                console.error('Error loading leave ', err);
            } finally {
                this.isLoading = false;
            }
        },

        openLeaveDialog(employee) {
            this.selectedEmployee = employee;
            this.loadLeaves(employee.id);
            this.$nextTick(() => {
                this.$refs.leaveDialog.showModal();
            });
        },

        closeLeaveDialog() {
            this.$refs.leaveDialog.close();
            this.selectedEmployee = null;
            this.leaves = [];
            this.leaveForm = {
                leave_type_id: '',
                leave_status_id: this.leaveStatuses.find(s => s.code === 'pending')?.id || '',
                date_start: '',
                date_end: '',
                reason: '',
            };
            this.formErrors = {};
        },

        getStatusColor(statusCode) {

            const status = this.leaveStatuses.find(s => s.code === statusCode);
            console.log(status.color);
            return status ? status.color : 'gray';
        },

        resetLeaveForm() {
            this.leaveForm = {
                date_start: '',
                date_end: '',
                reason: '',
            };
            this.formErrors = {};
        },

        async submitLeaveForm() {
            this.formErrors = {};
            this.isSubmitting = true;

            try {
                const response = await fetch('/ajax/leaves', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        employee_id: this.selectedEmployee.id,
                        leave_type_id: this.getTypeValue(),
                        date_start: this.leaveForm.date_start,
                        date_end: this.leaveForm.date_end,
                        reason: this.leaveForm.reason || null,
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    if (errorData.errors) {
                        this.formErrors = errorData.errors;
                    }
                    throw new Error('Validation failed');
                }


                await this.loadLeaves(this.selectedEmployee.id);
                this.resetLeaveForm();



            } catch (err) {
                console.error('Error submitting leave:', err);

            } finally {
                this.isSubmitting = false;
            }
        },

        formatDateRange(start, end) {
            if (!start || !end) return '';
            const startDate = new Date(start);
            const endDate = new Date(end);

            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            if (startDate.getFullYear() === endDate.getFullYear()) {

                const startStr = startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                const endStr = endDate.toLocaleDateString('en-US', options);
                return `${startStr} – ${endStr}`;
            }
            return `${startDate.toLocaleDateString('en-US', options)} – ${endDate.toLocaleDateString('en-US', options)}`;
        },

    }
}
