<?php

namespace App\Queries\EmployeeLeave;

use App\Models\EmployeeLeave;
use Illuminate\Pagination\LengthAwarePaginator;

final class EmployeeLeaveQuery
{
    public function __construct(
        private EmployeeLeave $model
    ) {}

    public function paginate(
        EmployeeLeaveFilters $filters,
        int $perPage = 10,
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator {
        $query = $this->baseQuery();


        if ($filters->search) {
            $query->where(function ($q) use ($filters) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', "%{$filters->search}%"));
            });
        }


        if ($filters->name) {
            $query->whereHas('user', fn($q) => $q->where('name', $filters->name));
        }

        if ($filters->status) {
            $query->whereHas('status', fn($q) => $q->where('code', $filters->status));
        }


        $allowed = ['created_at', 'id', 'date_start'];
        $orderBy = in_array($orderBy, $allowed, true) ? $orderBy : 'created_at';
        $orderDirection = strtolower($orderDirection) === 'asc' ? 'asc' : 'desc';

        return $query
            ->orderBy($orderBy, $orderDirection)
            ->paginate($perPage);
    }

    public function baseQuery()
    {
        return $this->model
            ->newQuery()
            ->with(['user', 'type', 'status'])
            ->whereHas('user', fn($q) => $q->where('user_type', 'employee'));
    }
}
