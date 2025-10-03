<div x-data="employeeCard({{ $employeeId ?? 'null' }})"
    class="overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300 rounded-lg border bg-card text-card-foreground"
    x-show="employee"
    x-cloak>
    <!-- Card Header -->
    <div class="bg-gradient-to-br from-primary/5 to-primary/10 pb-4 px-4 pt-4 rounded-t-lg">
        <div class="flex items-start gap-4">
            <!-- Avatar -->
            <div class="relative">
                <img
                    :src="employee.imagePath || '/placeholder.svg'"
                    :alt="employee.name"
                    class="h-16 w-16 rounded-full border-2 border-background object-cover"
                    x-show="employee.imagePath"
                    x-on:error="employee.imagePath = null" />
                <div
                    class="h-16 w-16 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-lg font-semibold"
                    x-show="!employee.imagePath">
                    <span x-text="getInitials(employee.name)"></span>
                </div>
            </div>

            <!-- Info -->
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-lg text-balance leading-tight" x-text="employee.name"></h3>

                <template x-if="employee.designationName">
                    <div class="flex items-center gap-1.5 mt-1 text-muted-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-briefcase">
                            <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            <path d="M22 20H2" />
                        </svg>
                        <span class="text-sm" x-text="employee.designationName"></span>
                    </div>
                </template>

                <template x-if="employee.employeeId">
                    <span class="inline-block mt-2 px-2 py-0.5 text-xs bg-secondary text-secondary-foreground rounded">
                        ID: <span x-text="employee.employeeId"></span>
                    </span>
                </template>
            </div>

            <!-- Actions -->
            <div class="flex gap-1">
                <button
                    @click="editEmployee()"
                    class="h-8 w-8 rounded-md hover:bg-accent flex items-center justify-center"
                    title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                    </svg>
                </button>
                <button
                    @click="deleteEmployee()"
                    class="h-8 w-8 rounded-md hover:bg-destructive/10 text-destructive flex items-center justify-center"
                    title="Eliminar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Card Content -->
    <div class="p-4 pt-2 space-y-3">
        <!-- Contact Info -->
        <div class="space-y-2">
            <template x-if="employee.mobile">
                <div class="flex items-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone text-muted-foreground">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    <span x-text="employee.mobile"></span>
                </div>
            </template>

            <template x-if="employee.address">
                <div class="flex items-start gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin text-muted-foreground mt-0.5">
                        <path d="M20 10c0-4.42-3.58-8-8-8s-8 3.58-8 8c0 2.5 1.2 4.71 3.09 6.14L12 22l4.91-3.86C18.8 16.71 20 14.5 20 10z" />
                    </svg>
                    <span class="text-pretty" x-text="employee.address"></span>
                </div>
            </template>
        </div>

        <!-- Personal Details -->
        <template x-if="employee.gender || employee.dateBirth">
            <div class="pt-2 border-t space-y-1.5">
                <template x-if="employee.gender">
                    <div class="flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user text-muted-foreground">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span class="text-muted-foreground">Género:</span>
                        <span x-text="employee.gender"></span>
                    </div>
                </template>
                <template x-if="employee.dateBirth">
                    <div class="flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar text-muted-foreground">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                            <path d="M16 2v4" />
                            <path d="M8 2v4" />
                            <path d="M3 10h18" />
                        </svg>
                        <span class="text-muted-foreground">Nacimiento:</span>
                        <span x-text="formatDate(employee.dateBirth)"></span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Employment Info -->
        <template x-if="employee.dateJoin">
            <div class="pt-2 border-t">
                <div class="flex items-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar text-muted-foreground">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                        <path d="M16 2v4" />
                        <path d="M8 2v4" />
                        <path d="M3 10h18" />
                    </svg>
                    <span class="text-muted-foreground">Fecha de ingreso:</span>
                    <span class="font-medium" x-text="formatDate(employee.dateJoin)"></span>
                </div>
            </div>
        </template>

        <!-- Salary Info -->
        <template x-if="employee.presentSalary || employee.salary">
            <div class="pt-2 border-t space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-muted-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign">
                            <line x1="12" x2="12" y1="2" y2="22" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                        <span>Salario actual:</span>
                    </div>
                    <span class="font-semibold text-primary" x-text="formatCurrency(employee.presentSalary || employee.salary)"></span>
                </div>

                <template x-if="employee.incrementSalary && employee.incrementSalary > 0">
                    <div class="flex items-center gap-2 text-sm bg-green-50 dark:bg-green-950/20 text-green-700 dark:text-green-400 px-2 py-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                            <polyline points="17 6 23 6 23 12" />
                        </svg>
                        <span>Incremento: <span x-text="formatCurrency(employee.incrementSalary)"></span></span>
                        <template x-if="employee.effectiveDate">
                            <span class="text-xs opacity-75" x-text="`(${formatDate(employee.effectiveDate)})`"></span>
                        </template>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>

<script>
    function employeeCard(employeeId) {
        return {
            employee: null,
            employeeId: employeeId,

            init() {
                if (this.employeeId) {
                    this.loadEmployee();
                }
            },

            async loadEmployee() {
                try {
                    const response = await fetch(`/api/employees/${this.employeeId}`);
                    if (!response.ok) throw new Error('Empleado no encontrado');
                    this.employee = await response.json();
                } catch (error) {
                    console.error('Error al cargar empleado:', error);
                    // Opcional: mostrar mensaje de error
                }
            },

            getInitials(name) {
                if (!name) return '?';
                return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
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
        };
    }
</script>