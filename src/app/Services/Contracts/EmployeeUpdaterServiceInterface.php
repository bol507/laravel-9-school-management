<?php

namespace App\Services\Contracts;

use App\DTO\EmployeeDTO;
use App\Models\User;
use Illuminate\Http\UploadedFile;

/**
 * Defines the contract for updating an existing employee in the system.
 * This service handles the coordination between updating the user account,
 * the employee profile, and managing an optional profile image upload or removal.
 */
interface EmployeeUpdaterServiceInterface
{
    /**
     * Updates an existing employee identified by the given ID using the provided data
     * and an optional new profile image.
     *
     * @param string $id The unique identifier of the employee to update.
     * @param \App\DTO\EmployeeDTO $data The validated employee data transfer object containing updated fields.
     * @param \Illuminate\Http\UploadedFile|null $image Optional new profile image to replace the current one.
     * @return \App\Models\User The updated User model representing the employee.
     */
    public function execute(string $id, EmployeeDTO $data, ?UploadedFile $image = null): User;
}
