<?php

namespace App\Queries\EmployeeLeave;

final class EmployeeLeaveFilters {
    public ?string $search;
    public ?string $name;
    public ?string $status;
    public ?string $employeeId;

    public function __construct(array $data = []) {
        $this->employeeId = $data['employee_id'] ?? null;
        $this->search = $data['search'] ?? null;
        $this->status = $data['status'] ?? null;
        $this->name = $data['name'] ?? null;
    }
}
