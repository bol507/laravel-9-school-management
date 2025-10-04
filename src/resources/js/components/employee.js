import axios from 'axios';
import paginationComponent from './pagination.js';
import createSelect from '../utils/create-select.js';

export default () => {

    const genderSelect = createSelect('Gender',null);// 'Gender' -> selectGender, openGender, GenderOptions

    return {
        employees: [],
        pagination: paginationComponent(5),
        searchTerm: '',

        ...genderSelect,

        init() {
            this.loadEmployees();
        },


        async loadEmployees(page = 1) {
            try {
                const params = {
                    limit: this.pagination.perPage,
                    page,
                    search: this.searchTerm || undefined,
                    gender: this.getGenderValue(),
                };

                if (this.searchTerm) params.search = this.searchTerm;

                const { data } = await axios.get('/ajax/employees', { params });

                this.employees = data.employees;
                this.pagination.initPagination(data.pagination);
                this.initGenderOptions(data.genders);
            } catch (err) {
                this.employees = [];
                this.pagination.initPagination({
                        current_page: 1,
                        last_page: 1,
                        total: 0,
                        from: 0,
                        to: 0
                    });
                this.initGenderOptions([]);
            }
        },

        async loadEmployee() {
            try {
                const { data } = await axios.get(`/ajax/employees/${this.employeeId}`);
                this.employee = await data.employee
            } catch (error) {
                console.error('Error loading employees:', error);
            }
        },

        getInitials(name) {
            if (!name) return '?';
            return name
                .split(' ')
                .map(n => n[0])
                .join('')
                .toUpperCase()
                .substring(0, 2);
        },

        goToPage(page) {
            this.pagination.setPage(page);
            this.loadEmployees(page);
        },

        formatDate(dateString) {
                    if (!dateString) return '';
                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    };
                    return new Date(dateString).toLocaleDateString('es-ES', options);
                },

            formatCurrency(amount) {
                if (amount == null) return 'N/A';
                return new Intl.NumberFormat('es-ES', {
                    style: 'currency',
                    currency: 'USD', // o 'MXN', 'COP', etc.
                    minimumFractionDigits: 0,
                }).format(amount);
            },

            editEmployee() {
                // Aquí puedes abrir un modal o redirigir
                alert('Editar empleado: ' + this.employee.name);
                // Ejemplo: window.location.href = `/employees/${this.employeeId}/edit`;
            },

            deleteEmployee() {
                if (confirm(`¿Eliminar a ${this.employee.name}?`)) {
                    // Llamada AJAX para eliminar
                    fetch(`/api/employees/${this.employeeId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).then(() => {
                        this.employee = null;
                        // Opcional: recargar lista
                    });
                }
            }
    }
};
