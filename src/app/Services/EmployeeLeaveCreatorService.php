<?php

namespace App\Services;

use App\DTO\EmployeeLeaveDTO;
use App\Repositories\Contracts\EmployeeLeaveRepositoryInterface;
use App\Services\Contracts\EmployeeLeaveCreatorServiceInterface;

final class EmployeeLeaveCreatorService implements EmployeeLeaveCreatorServiceInterface {

    public function __construct(
        private EmployeeLeaveRepositoryInterface     $repository
    ) {}

    public function execute( array $data): void {

        $leaveData = array_merge($data, [
            'applied_at' => $data['applied_at'] ?? now(),
            'approved_by' => null,
        ]);

        $this->repository->create($leaveData);
    }
}
