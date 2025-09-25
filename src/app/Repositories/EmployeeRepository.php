<?php

namespace App\Repositories;

use App\DTO\EmployeeDTO;
use App\Models\User;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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

    // Find employee by email
    public function findOrFail(string $id): User
    {
        $model = $this->findById($id);
        if (!$model) {
            throw new ModelNotFoundException("Employee with ID {$id} not found.");
        }
        return $model;
    }

    // Find employee DTO by ID
    public function findDTOOrFail(string $id): EmployeeDTO {
        $user = $this->findOrFail($id);
        return $this->toEmployeeDTO($user);
    }

    // For pagination with search and filters
    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
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

    private function toEmployeeDTO(User $user): EmployeeDTO
    {
        $profile = $user->profile;

        return new EmployeeDTO([
            'id'            => $user->id,
            'name'          => $user->name,
            'gender'        => $profile?->gender,
            'fatherName'    => $profile?->father_name,
            'motherName'    => $profile?->mother_name,
            'mobile'        => $profile?->mobile,
            'address'       => $profile?->address,
            'religion'      => $profile?->religion,
            'dateBirth'     => $profile?->date_birth,
            'dateJoin'      => $profile?->date_join,
            'salary'        => $profile?->salary !== null ? (float) $profile->salary : null,
            'idNo'          => $profile?->id_no !== null ? (string) $profile->id_no : null,
            'code'          => $profile?->code,
            'imagePath'     => $profile?->image_path,
            'designationId' => $profile?->designation_id,
        ]);
    }
}
