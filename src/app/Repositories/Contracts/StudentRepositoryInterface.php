<?php

namespace App\Repositories\Contracts;

use App\DTO\StudentDTO;
use App\Models\AssignStudent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface StudentRepositoryInterface
{
    /**
     * Retrieves all students as a collection.
     *
     * @return Collection A collection of all student records.
     */
    public function all(): Collection;

    /**
     * Finds a student by their unique identifier.
     *
     * @param string $id The unique identifier of the student.
     * @return AssignStudent|null Returns the student model if found, otherwise null.
     */
    public function findById(string $id): ?AssignStudent;

    /**
     * Finds a student by their unique identifier and throws an exception if not found.
     *
     * @param string $id The unique identifier of the student.
     * @return AssignStudent Returns the assignStudent model.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the student is not found.
     */
    public function findOrFail(string $id): AssignStudent;

    /**
     * Finds a student by their unique identifier and returns their data as a DTO.
     * Throws an exception if the student is not found.
     *
     * @param string $id The unique identifier of the student.
     * @return StudentDTO Returns the student data transfer object.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the student is not found.
     */
    public function findDTOOrFail(string $id): StudentDTO;

    /**
     * Paginates the list of students with optional search and filtering capabilities.
     *
     * @param int $perPage Number of records per page (default: 10).
     * @param string|null $search Optional search term to filter students by name, email, etc.
     * @param array $filters Additional filter criteria (e.g., status, enrollment date).
     * @param string $orderBy Column to sort by (default: 'created_at').
     * @param string $orderDirection Sort direction ('asc' or 'desc', default: 'desc').
     * @return LengthAwarePaginator Paginated result set with metadata.
     */
    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy = 'created_at',
        string $orderDirection = 'desc'
    ): LengthAwarePaginator;
}
