<?php

namespace App\Services\Contracts;

use App\DTO\EmployeeLeaveDTO;
use App\Queries\EmployeeLeave\EmployeeLeaveFilters;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EmployeeLeaveServiceInterface
{
    public function getPaginatedDTOs(
        EmployeeLeaveFilters $filters,
        int $perPage = 10,
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator ;

    public function findDTO(string $id): EmployeeLeaveDTO;
}
