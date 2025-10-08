<?php

namespace App\Repositories\Contracts;

use App\DTO\EmployeeDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Contract defining the public API for employee data access.
 * This interface abstracts how employee-related data is retrieved, created, and updated,
 * allowing for multiple implementations (e.g., Eloquent, cache, external API).
 */
interface EmployeeRepositoryInterface
{
    /**
     * Retrieve all employees as a Collection of User models.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection;

    /**
     * Find an employee by their ID and return the associated User model, or null if not found.
     *
     * @param string $id The employee's unique identifier.
     * @return \App\Models\User|null
     */
    public function findById(string $id): ?User;

    /**
     * Find an employee by ID and return the User model; throw a ModelNotFoundException if not found.
     *
     * @param string $id The employee's unique identifier.
     * @return \App\Models\User
     */
    public function findOrFail(string $id): User;

    /**
     * Find an employee by ID and return their data as an EmployeeDTO; throw an exception if not found.
     *
     * @param string $id The employee's unique identifier.
     * @return \App\DTO\EmployeeDTO
     */
    public function findDTOOrFail(string $id): EmployeeDTO;

    /**
     * Paginate employees with optional search, filtering, and sorting.
     *
     * @param int $perPage Number of records per page.
     * @param string|null $search Optional search term (e.g., name, email).
     * @param array $filters Additional filter criteria (e.g., by role, status).
     * @param string $orderBy Column to sort by.
     * @param string $orderDirection Sort direction ('asc' or 'desc').
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator;

    /**
     * Create a new employee by associating user account data with profile (employee-specific) data.
     *
     * @param array $userData User-related attributes (e.g., email, password).
     * @param array $profileData Employee profile attributes (e.g., name, designation, salary).
     * @return \App\Models\User The created User model.
     */
    public function createEmployee(
        array $userData,
        array $profileData,
    ): User;

    /**
     * Update an existing employee's user and profile data.
     *
     * @param string $id The employee's unique identifier.
     * @param array $userData Updated user attributes.
     * @param array $profileData Updated employee profile attributes.
     * @return \App\Models\User The updated User model.
     */
    public function updateEmployee(
        string $id,
        array $userData,
        array $profileData,
    ): User;
}
