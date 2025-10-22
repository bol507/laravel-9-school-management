<?php

namespace App\Queries\EmployeeLeave\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmployeeLeaveQueryBuilderInterface {
    public function forEmployee(string $employeeId): self;
    public function search(string $term): self;
    public function status(string $code): self;
    public function orderBy(string $column, string $direction = 'asc'): self;
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function get(): Collection;
}
