<?php

namespace App\Repositories\Contracts;

use App\DTO\EmployeeLeaveDTO;
use App\Models\EmployeeLeave;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EmployeeLeaveRepositoryInterface {

    public function all() : Collection;
    public function find(string $id): ?EmployeeLeave;
    public function findOrFail(string $id): EmployeeLeave;
    public function findByEmployee(string $id): Collection;
    public function create(array $data): EmployeeLeave;
    public function update(EmployeeLeave $leave, array $raw): EmployeeLeave;
    public function delete(EmployeeLeave $leave): bool;
}
