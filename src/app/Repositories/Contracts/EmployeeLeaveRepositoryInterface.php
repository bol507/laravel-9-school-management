<?php

namespace App\Repositories\Contracts;

use App\DTO\EmployeeLeaveDTO;
use App\Models\EmployeeLeave;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EmployeeLeaveRepositoryInterface {

    public function all() : Collection;
    public function findById(string $id): ?EmployeeLeave;
    public function findOrFail(string $id): EmployeeLeave;
    public function findDTOOrFail(string $id): EmployeeLeaveDTO;
    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator;
    public function findByEmployeeId(string $id): Collection;
    public function create(array $data): EmployeeLeave;
}
