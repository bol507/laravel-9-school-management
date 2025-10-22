<?php

namespace App\Repositories;


use App\Models\EmployeeLeave;
use App\Repositories\Contracts\EmployeeLeaveRepositoryInterface;
use Illuminate\Support\Collection;

class EmployeeLeaveRepository implements EmployeeLeaveRepositoryInterface
{
    private static ?string $pendingStatusId = null;

    public function __construct(
        private EmployeeLeave $model
    ) {}

    private function baseQuery() {
        return $this->model
            ->newQuery()
            ->with(['user', 'type', 'status'])
            ->whereHas('user', fn($q) => $q->where('user_type', 'employee'));
    }

    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function find(string $id): ?EmployeeLeave
    {
        return $this->baseQuery()->find($id);
    }

    public function findOrFail(string $id): EmployeeLeave
    {
        return $this->baseQuery()->findOrFail($id);
    }

    public function findByEmployee(string $employeeId): Collection
    {
        return $this->baseQuery()
            ->where('employee_id', $employeeId)
            ->get();
    }



    public function create(array $raw): EmployeeLeave {
        return $this->model->create($raw)->load(['user', 'type', 'status']);
    }

    public function update(EmployeeLeave $leave, array $raw): EmployeeLeave {
        $leave->update($raw);
        return $leave->fresh(['user', 'type', 'status']);
    }

    public function delete(EmployeeLeave $leave): bool {
        return $leave->delete();
    }

}
