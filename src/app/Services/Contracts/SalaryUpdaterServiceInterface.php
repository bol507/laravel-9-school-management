<?php

namespace App\Services\Contracts;

use App\DTO\SalaryDTO;

interface SalaryUpdaterServiceInterface
{
    public function execute(
        string $employeeId,
        SalaryDTO $data,
    ): void ;
}
