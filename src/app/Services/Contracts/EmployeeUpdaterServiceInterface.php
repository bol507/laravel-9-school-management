<?php

namespace App\Services\Contracts;

use App\DTO\EmployeeDTO;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface EmployeeUpdaterServiceInterface
{
    public function execute(string $id, EmployeeDTO $data, ?UploadedFile $image = null): User;
}
