<?php

namespace App\Repositories;

use App\DTO\EmployeeLeaveDTO;
use App\Models\EmployeeLeave;
use App\Models\LeaveStatus;
use App\Repositories\Contracts\EmployeeLeaveRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class EmployeeLeaveRepository implements EmployeeLeaveRepositoryInterface
{
    private static ?string $pendingStatusId = null;

    private function baseQuery()
    {
        return EmployeeLeave::with(['user', 'type', 'status'])
            ->whereHas('user', function ($q) {
                $q->where('user_type', 'employee');
            });
    }

    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function findById(string $id): ?EmployeeLeave
    {
        return $this->baseQuery()->find($id);
    }

    public function findOrFail(string $id): EmployeeLeave
    {
        $model = $this->findById($id);
        if (!$model) {
            throw new ModelNotFoundException("leave with ID {$id} not found.");
        }
        return $model;
    }

    public function findDTOOrFail(string $id): EmployeeLeaveDTO
    {
        $leave = $this->findOrFail($id);
        return $this->toDTO($leave);
    }

    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string
        $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator {
        $query = $this->baseQuery();

        // Search functionality
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        // Apply filters
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
                $query->whereHas('user', function ($q) use ($key, $value) {
                    if (in_array($key, ['name'], true)) {
                        $q->where($key, $value);
                    } else {
                        $escapedValue = addcslashes($value, '%_\\');
                        $q->where($key, 'LIKE', "%{$escapedValue}%");
                    }
                });
            }
        }

        // Validate orderBy and orderDirection
        $allowedColumns = ['name',  'created_at'];
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
                fn(EmployeeLeave $user) => $this->toDTO($user)
            );

        return $paginator->setCollection($dtoCollection);
    }

    public function findByEmployeeId(string $id): Collection
    {
        $leaves = $this->baseQuery()
            ->where('employee_id', $id)
            ->get(); //get collection.

        return $leaves->map(fn(EmployeeLeave $leave) => $this->toDTO($leave));
    }

    public function create(array $data): EmployeeLeave {

        $pendingStatusId = $this->getPendingStatusId();

        $leave = EmployeeLeave::create([
            'employee_id' => $data['employee_id'],
            'leave_type_id' => $data['leave_type_id'],
            'leave_status_id' => $pendingStatusId,
            'date_start' => $data['date_start'],
            'date_end' => $data['date_end'],
            'reason' => $data['reason'] ?? null,
            'applied_at' => $data['applied_at'] ?? now(),
            'approved_by' => null, //  $data['approved_by']
        ]);


        return $leave->load(['user','type', 'status']);
    }

    private function getPendingStatusId(): string
    {
        if (self::$pendingStatusId === null) {
            self::$pendingStatusId = LeaveStatus::where('code', 'pending')->value('id');
            if (!self::$pendingStatusId) {
                throw new \RuntimeException('Default leave status "pending" not found');
            }
        }
        return self::$pendingStatusId;
    }

    private function toDTO(EmployeeLeave $data): EmployeeLeaveDTO
    {
        $typeCode = $data->type?->code ?? 'unknown';
        $statusCode = $data->status?->code ?? 'unknown';

        return new EmployeeLeaveDTO([
            'id'                => $data->id,
            'employeeId'        => $data?->employee_id,
            'type'              => $typeCode,
            'status'            => $statusCode,
            'reason'            => $data?->reason,
            'dateStart'         => $data?->date_start,
            'dateEnd'           => $data?->date_end,
            'appliedAt'         => $data?->applied_at,
            'approvedBy'        => $data?->approved_by,
        ]);
    }
}
