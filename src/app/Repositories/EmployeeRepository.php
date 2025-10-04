<?php

namespace App\Repositories;

use App\DTO\EmployeeDTO;
use App\Models\EmployeeSalaryChange;
use App\Models\Sequence;
use App\Models\User;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EmployeeRepository implements EmployeeRepositoryInterface
{
    // Base query for employees
    private function baseQuery() {
        return User::with(['profile.designation','salaryChange'])
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
    public function findOrFail(string $id): User{
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
                        $q->where('mobile', 'LIKE', "%{$search}%")
                            ->orWhere('address', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Apply filters
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
                $query->whereHas('profile', function ($q) use ($key,$value) {
                    $q->where($key,'LIKE',"%{$value}%" );
                });
            }
        }

        // Validate orderBy and orderDirection
        $allowedColumns = ['id', 'name', 'email', 'created_at'];
        if (!in_array($orderBy, $allowedColumns, true)) {
            $orderBy = 'id';
        }

        $orderDirection = strtolower($orderDirection) === 'desc' ? 'desc' : 'asc';

        $paginator = $query
            ->orderBy($orderBy, $orderDirection)
            ->paginate($perPage);

        $dtoCollection = $paginator
            ->getCollection()
            ->map(
                fn(User $user) => $this->toEmployeeDTO($user)
            );

        return $paginator->setCollection($dtoCollection);

    }

    public function createEmployee($userData, $profileData): User{

            $user = User::create($userData);
            // Generar el siguiente número de forma segura
            $nextNumber = DB::transaction(function () {
                $sequence = Sequence::where('name', 'employee_code')->lockForUpdate()->first();

                if (!$sequence) {
                    $sequence = Sequence::create([
                        'name' => 'employee_code',
                        'value' => 1,
                    ]);
                    return 1;
                }

                $sequence->value++;
                $sequence->save();

                return $sequence->value;
            });

            $profileData['id_no'] = 'EMP-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            $user->profile()->create($profileData);

            if ($profileData['salary'] !== null) {
                EmployeeSalaryChange::create([
                    'employee_id' => $user->id,
                    'previous_salary' => 0,
                    'present_salary' => $profileData['salary'] ,
                    'increment_salary' => $profileData['salary'] , // initial salary
                    'effective_date' => $profileData['date_join']  ?? now(),
                ]);
            }
            return $user;

    }

    public function updateEmployee($id, $userData, $profileData): user{

            $user = $this->findOrFail($id);
            $user->update($userData);
            $user->profile()->update($profileData);


            if ($profileData['salary'] !== null) {
                $currentSalary = $user->profile->getOriginal('salary'); // Get the original salary before update
                // Only update salary track if the salary has changed
                if (number_format($currentSalary ?? 0, 2, '.', '') !== number_format($profileData['salary'], 2, '.', '')) {
                    $this->updateSalaryTrack(
                        employeeId: $id,
                        newSalary: $profileData['salary'],
                        effectiveDate: $profileData['date_join'] ?? now()
                    );
                }
            }
            return $user;
    }

    private function toEmployeeDTO(User $user): EmployeeDTO
    {
        $profile = $user->profile;
        $salaryChange = $user->salaryChange->last();

        return new EmployeeDTO([
            'id'                => $user->id,
            'employeeId'        => $profile?->user_id,
            'name'              => $user->name,
            'gender'            => $profile?->gender,
            'fatherName'        => $profile?->father_name,
            'motherName'        => $profile?->mother_name,
            'mobile'            => $profile?->mobile,
            'address'           => $profile?->address,
            'religion'          => $profile?->religion,
            'dateBirth'         => $profile?->date_birth,
            'dateJoin'          => $profile?->date_join,
            'salary'            => $profile?->salary !== null ? (float) $profile->salary : null,
            'idNo'              => $profile?->id_no !== null ? (string) $profile->id_no : null,
            'code'              => $profile?->code,
            'imagePath'         => $profile?->image_path,
            'designationId'     => $profile?->designation_id,
            'designationName'   => $profile?->designation?->name,
            'presentSalary'     => $salaryChange?->present_salary,
            'previousSalary'    => $salaryChange?->previous_salary,
            'incrementSalary'   => $salaryChange?->increment_salary,
            'effectiveDate'    => $salaryChange?->effective_date,
        ]);
    }

    private function updateSalaryTrack(string $employeeId, float $newSalary, Carbon $effectiveDate): void
    {
        $existingRecord = EmployeeSalaryChange::where('employee_id', $employeeId)->first();

        $salaryChange = $existingRecord ?? new EmployeeSalaryChange();
        $salaryChange->employee_id = $employeeId;
        $salaryChange->previous_salary = $existingRecord?->present_salary ?? 0;
        $salaryChange->present_salary = $newSalary;
        $salaryChange->increment_salary = $newSalary - $salaryChange->previous_salary;
        $salaryChange->effective_date = $effectiveDate;

        $salaryChange->save();
    }
}
