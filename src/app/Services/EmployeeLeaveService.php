<?php

namespace App\Services;

use App\DTO\EmployeeLeaveDTO;
use App\Queries\EmployeeLeave\EmployeeLeaveFilters;
use App\Queries\EmployeeLeave\EmployeeLeaveQuery;
use App\Repositories\Contracts\EmployeeLeaveRepositoryInterface;
use App\Services\Contracts\EmployeeLeaveServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class EmployeeLeaveService implements EmployeeLeaveServiceInterface
{

    private $query;
    private $repo;

    public function __construct(EmployeeLeaveQuery $query, EmployeeLeaveRepositoryInterface $repo)
    {
        $this->query = $query;
        $this->repo= $repo;
    }


    public function getPaginatedDTOs(
        EmployeeLeaveFilters $filters,
        int $perPage = 10,
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator {
        $paginator = $this->query->paginate(
            $filters,
            $perPage,
            $orderBy,
            $orderDirection
        );

        $dtoCollection = $paginator->getCollection()->map(
            fn($leave) => $this->toDTO($leave)
        );

        return $paginator->setCollection($dtoCollection);
    }

    public function findDTO(string $id): EmployeeLeaveDTO
    {
        $leave = $this->repo->findOrFail($id);
        return $this->toDTO($leave);
    }

    private function toDTO($leave): EmployeeLeaveDTO
    {
        return new EmployeeLeaveDTO([
            'id'         => $leave->id,
            'employeeId' => $leave->employee_id,
            'type'       => $leave->type?->code ?? 'unknown',
            'status'     => $leave->status?->code ?? 'unknown',
            'reason'     => $leave->reason,
            'dateStart'  => $leave->date_start,
            'dateEnd'    => $leave->date_end,
            'appliedAt'  => $leave->applied_at,
            'approvedBy' => $leave->approved_by,
        ]);
    }
}
