<?php

namespace App\Services\Contracts;

use App\DTO\EmployeeLeaveDTO;

interface EmployeeLeaveCreatorServiceInterface
{
    public function execute(
        array $data,
    ): void ;
}
