import axios from 'axios';
import paginationComponent from './pagination.js';
import createSelect from '../utils/create-select.js';

export default () => {

    const genderSelect = createSelect('Gender',null);// 'Gender' -> selectGender, openGender, GenderOptions
    const genderForm = createSelect('GenderForm', null);
    const designationForm = createSelect('DesignationForm',null)
    return {
        employees: [],
        pagination: paginationComponent(5),
        searchTerm: '',
        //form state
        isEditing: false,
        employeeId: null,
        employeeForm: {
            name: '',
            father_name: '',
            mother_name: '',
            mobile: '',
            address: '',
            religion: '',
            date_birth: '',
            date_join: '',
            salary: '',
            image: null,
            gender: null,
            designation_id:null,
        },
        //image
        currentImageUrl:null,
        //filter
        ...genderSelect,
        //form
        ...genderForm,
        ...designationForm,

        init() {
            this.loadEmployees();
        },

        loadSelects(genders,designations) {
            try {
                const genderOptions = Object.entries(genders).map(([key, label]) => ({
                    value: key,
                    label: label
                }));
                const designationOptions = designations.map(d => ({
                    value: d.id,
                    label: d.name
                }));
                this.initGenderOptions(genderOptions);
                this.initGenderFormOptions(genderOptions);
                this.initDesignationFormOptions(designationOptions);
            } catch (err) {
                console.error('Error loading genders:', err);
                this.initGenderOptions([]);
                this.initGenderFormOptions([]);
                this.initDesignationFormOptions([])
            }
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
                this.loadSelects(data.genders,data.designations);
            } catch (err) {
                this.employees = [];
                this.pagination.initPagination({
                        current_page: 1,
                        last_page: 1,
                        total: 0,
                        from: 0,
                        to: 0
                    });

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

        openCreateForm() {
            this.isEditing = false;
            this.employeeId = null;
            this.resetForm();
            this.clearGenderForm();
        },

        resetForm() {
            this.employeeForm = {
                name: '',
                father_name: '',
                mother_name: '',
                mobile: '',
                address: '',
                religion: '',
                date_birth: '',
                date_join: '',
                salary: '',
                gender: null,
                designation_id:null,
                image: null,
            };
            this.currentImageUrl = null;
        },

        async saveEmployee() {
            const formData = new FormData();

            Object.entries(this.employeeForm).forEach(([key, value]) => {
                if (value !== null && value !== undefined) {
                    formData.append(key, value);
                }
            });

            formData.append('gender', this.getGenderFormValue());
            formData.append('designation_id', this.getDesignationFormValue());

            if (this.employeeForm.image) {
                formData.append('image', this.employeeForm.image);
            }

            try {
                const url = this.isEditing
                    ? `/ajax/employees/${this.employeeId}?_method=PUT`
                    : '/ajax/employees';

                await axios.post(url, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });

                this.loadEmployees();
                this.$refs.employeeDialog.close();
            } catch (err) {
                console.error('Error saving employee:', err);
            }
        },


        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('show-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
                this.employeeForm.image = file;
            }
        },

        editEmployee(employee) {
            this.isEditing = true;
            console.log('editEmployee llamado', employee);
            this.employeeId = employee.id;

            this.employeeForm = {
                name: employee.name || '',
                father_name: employee.fatherName || '',
                mother_name: employee.motherName || '',
                mobile: employee.mobile || '',
                address: employee.address || '',
                religion: employee.religion || '',
                date_birth: employee.dateBirth ? employee.dateBirth.slice(0, 10) : '',
                date_join: employee.dateJoin ? employee.dateJoin.slice(0, 10) : '',
                salary: employee.salary || '',
                image: null,
            };

            // load gender and designation
            this.selectedGenderForm = employee.gender || null;
            this.selectedDesignationForm = employee.designationId || null;

            //load image
            const origin = location.origin;
            this.currentImageUrl = employee.imagePath && employee.imagePath.startsWith('http')
            ? employee.imagePath
            : `${origin}/upload/no_image.jpg`;

            // Open dialog
            this.$nextTick(() => {
                this.$refs.employeeDialog.showModal();
            });
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

            /*editEmployee() {
                // Aquí puedes abrir un modal o redirigir
                alert('Editar empleado: ' + this.employee.name);
                // Ejemplo: window.location.href = `/employees/${this.employeeId}/edit`;
            },*/

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
