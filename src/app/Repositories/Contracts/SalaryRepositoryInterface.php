<?php

namespace App\Repositories\Contracts;

use App\DTO\SalaryDTO;
use App\Models\EmployeeSalaryChange;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface SalaryRepositoryInterface
{


    public function all(): Collection ;

    public function findById(string $id): ?EmployeeSalaryChange ;

    public function findOrFail(string $id): EmployeeSalaryChange ;

    public function findDTOOrFail(string $id): SalaryDTO ;

    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy ='created_at',
        string $orderDirecction ='desc',
    ): LengthAwarePaginator ;

    public function createSalaryChange(array $data): EmployeeSalaryChange;

    public function getSalaryHistoryByEmployeeId(string $employeeId): Collection;

}
