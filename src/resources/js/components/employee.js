import axios from 'axios';
import paginationComponent from './pagination.js';
import createSelect from '../utils/create-select.js';

/**
 * Alpine.js component for managing the employee list page with:
 * - Dynamic pagination
 * - Search and gender filtering
 * - Create/edit employee form (with image preview)
 * - Custom select dropdowns for gender and designation
 */
export default () => {
    // Create reusable select handlers for filters and form fields
    const genderSelect = createSelect('Gender', null);        // For filter dropdown
    const genderForm = createSelect('GenderForm', null);      // For form dropdown
    const designationForm = createSelect('DesignationForm', null); // For form dropdown

    return {
        // === State ===
        employees: [],                     // List of employees to display
        pagination: paginationComponent(6), // Pagination logic (6 items per page)
        searchTerm: '',                    // Current search input

        // Form state
        isEditing: false,                  // Whether in edit or create mode
        employeeId: null,                  // ID of employee being edited (if any)
        employeeForm: {                    // Form data for create/edit
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
            designation_id: null,
        },

        // Image preview
        currentImageUrl: null,

        // === Mixins: inject select logic into component ===
        ...genderSelect,        // Adds: selectedGender, openGender, GenderOptions, etc.
        ...genderForm,          // Adds: selectedGenderForm, openGenderForm, GenderFormOptions, etc.
        ...designationForm,     // Adds: selectedDesignationForm, openDesignationForm, etc.

        /**
         * Initialize the component by loading the first page of employees.
         */
        init() {
            this.loadEmployees();
        },

        /**
         * Load gender and designation options into the select dropdowns.
         *
         * @param {Object} genders - Key-value map of gender options (e.g., { Male: 'Male', Female: 'Female' })
         * @param {Array} designations - Array of designation objects [{ id, name }, ...]
         */
        loadSelects(genders, designations) {
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
                this.initDesignationFormOptions([]);
            }
        },

        /**
         * Fetch employees from the backend with pagination, search, and gender filter.
         *
         * @param {number} page - Page number to fetch (default: 1)
         */
        async loadEmployees(page = 1) {
            try {
                const params = {
                    limit: this.pagination.perPage,
                    page,
                    search: this.searchTerm || undefined,
                    gender: this.getGenderValue(), // From filter dropdown
                };

                const { data } = await axios.get('/ajax/employees', { params });

                this.employees = data.employees;
                this.pagination.initPagination(data.pagination);
                this.loadSelects(data.genders, data.designations);
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

        /**
         * Generate initials from a full name (e.g., "John Doe" → "JD").
         *
         * @param {string} name - Full name
         * @returns {string} Two-letter initials
         */
        getInitials(name) {
            if (!name) return '?';
            return name
                .split(' ')
                .map(n => n[0])
                .join('')
                .toUpperCase()
                .substring(0, 2);
        },

        /**
         * Navigate to a specific page and reload employees.
         *
         * @param {number} page - Target page number
         */
        goToPage(page) {
            this.pagination.setPage(page);
            this.loadEmployees(page);
        },

        /**
         * Open the employee creation form in "create" mode.
         */
        openCreateForm() {
            this.isEditing = false;
            this.employeeId = null;
            this.resetForm();
            this.clearGenderForm(); // Reset form dropdowns
        },

        /**
         * Reset the employee form to default empty values.
         */
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
                designation_id: null,
                image: null,
            };
            this.currentImageUrl = null;
        },

        /**
         * Submit the employee form (create or update).
         */
        async saveEmployee() {
            const formData = new FormData();

            // Append all form fields
            Object.entries(this.employeeForm).forEach(([key, value]) => {
                if (value !== null && value !== undefined) {
                    formData.append(key, value);
                }
            });

            // Append values from custom selects (not in employeeForm)
            formData.append('gender', this.getGenderFormValue());
            formData.append('designation_id', this.getDesignationFormValue());

            // Append image if selected
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

                // Reload employee list and close modal
                this.loadEmployees();
                this.$refs.employeeDialog.close();
            } catch (err) {
                console.error('Error saving employee:', err);
            }
        },

        /**
         * Preview selected image in the form.
         *
         * @param {Event} event - File input change event
         */
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

        /**
         * Populate the form with employee data for editing.
         *
         * @param {Object} employee - Employee DTO object
         */
        editEmployee(employee) {
            this.isEditing = true;
            this.employeeId = employee.id;

            // Fill form fields
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

            // Set select dropdown values
            this.selectedGenderForm = employee.gender || null;
            this.selectedDesignationForm = employee.designationId || null;

            // Set image preview URL
            const origin = location.origin;
            this.currentImageUrl = employee.imagePath && employee.imagePath.startsWith('http')
                ? employee.imagePath
                : `${origin}/upload/no_image.jpg`;

            // Open modal after DOM update
            this.$nextTick(() => {
                this.$refs.employeeDialog.showModal();
            });
        },

        /**
         * Format a date string for display (e.g., "Jan 5, 2024").
         *
         * @param {string} dateString - ISO date string
         * @returns {string} Formatted date
         */
        formatDate(dateString) {
            if (!dateString) return '';
            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            return new Date(dateString).toLocaleDateString('es-ES', options);
        },

        /**
         * Format a number as currency (e.g., 1500 → "$1,500").
         *
         * @param {number} amount - Numeric amount
         * @returns {string} Formatted currency string
         */
        formatCurrency(amount) {
            if (amount == null) return 'N/A';
            return new Intl.NumberFormat('es-ES', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0,
            }).format(amount);
        },

        /**
         * Delete an employee (currently commented out in favor of backend-only delete).
         */
        deleteEmployee() {
            if (confirm(`¿Eliminar a ${this.employee.name}?`)) {
                fetch(`/api/employees/${this.employeeId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(() => {
                    this.employee = null;
                });
            }
        }
    };
};
