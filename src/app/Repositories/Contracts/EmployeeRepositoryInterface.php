<?php
namespace App\Repositories\Contracts;

use App\DTO\EmployeeDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface{

    public function all(): Collection;
    public function findById(string $id): ?User;
    public function findOrFail(string $id): User;
    public function findDTOOrFail(string $id): EmployeeDTO;

    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator;
    public function createEmployee(
        array $userData,
        array $profileData,
    ): User;

    public function updateEmployee(
        string $id,
        array $userData,
        array $profileData,
    ): User;
}
