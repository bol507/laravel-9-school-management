<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\EmployeeSalaryChange;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EmployeeRepository implements EmployeeRepositoryInterface
{
    // Base query for employees
    private function baseQuery() {
        return User::with('profile')
            ->where('user_type', 'employee');
    }
    // Get all employees
    public function all(): Collection {
        return $this->baseQuery()->get();
    }
    // Find employee by ID
    public function findById(string $id): ?User {
        return $this->baseQuery()->find($id);
    }
    // For pagination with search and filters
    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy = 'created_at',
        string $orderDirection = 'asc'
    ): LengthAwarePaginator {
        $query = $this->baseQuery();

        // Search functionality
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhereHas('profile', function ($q) use ($search) {
                        $q->where('phone', 'LIKE', "%{$search}%")
                            ->orWhere('address', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Apply filters
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
                $query->where($key, $value);
            }
        }

        // Validate orderBy and orderDirection
        $allowedColumns = ['id', 'name', 'email', 'created_at'];
        if (!in_array($orderBy, $allowedColumns, true)) {
            $orderBy = 'id';
        }

        $orderDirection = strtolower($orderDirection) === 'desc' ? 'desc' : 'asc';

        return $query->orderBy($orderBy, $orderDirection)
            ->paginate($perPage);
    }
}
