<?php

namespace App\Services\Contracts;

use App\DTO\EmployeeDTO;
use App\Models\User;
use Illuminate\Http\UploadedFile;

/**
 * Defines the contract for creating a new employee in the system.
 * This service handles the coordination between user account creation,
 * employee profile setup, optional image upload, and any related business logic.
 */
interface EmployeeCreatorServiceInterface
{
    /**
     * Creates a new employee using the provided data and optional profile image.
     *
     * @param \App\DTO\EmployeeDTO $data The validated employee data transfer object.
     * @param \Illuminate\Http\UploadedFile|null $image Optional profile image to associate with the employee.
     * @return \App\Models\User The newly created User model representing the employee.
     */
    public function execute(EmployeeDTO $data, ?UploadedFile $image = null): User;
}
