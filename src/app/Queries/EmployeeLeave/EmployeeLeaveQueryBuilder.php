<?php

namespace App\Queries\EmployeeLeave;

use App\Queries\EmployeeLeave\Contracts\EmployeeLeaveQueryBuilderInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeLeaveQueryBuilder implements EmployeeLeaveQueryBuilderInterface {
    private array $filters = [];
    private array $order = ['created_at', 'desc'];
    private ?int $perPage = null;

    public function __construct(
        private  EmployeeLeaveQuery $query
    ) {}

    public static function make(): self
    {
        return app(self::class);
    }

    public function forEmployee(string $employeeId): self
    {
        $this->filters['employeeId'] = $employeeId;
        return $this;
    }

    public function search(string $term): self
    {
        $this->filters['search'] = $term;
        return $this;
    }

    public function status(string $code): self
    {
        $this->filters['status'] = $code;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'desc'): self
    {
        $this->order = [$column, $direction];
        return $this;
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        $filters = new EmployeeLeaveFilters($this->filters);
        [$column, $dir] = $this->order;

        return $this->query->paginate($filters, $perPage, $column, $dir);
    }

    public function get(): Collection
    {

        $filters = new EmployeeLeaveFilters($this->filters);
        [$column, $dir] = $this->order;

        return $this->query->baseQuery()
            ->tap(fn($q) => $this->applyFilters($q, $filters))
            ->orderBy($column, $dir)
            ->get();
    }

    private function applyFilters($query, EmployeeLeaveFilters $f): void
    {
        if ($f->search)   $query->whereHas('user',   fn($q) => $q->where('name', 'like', "%{$f->search}%"));
        if ($f->status)   $query->whereHas('status', fn($q) => $q->where('code', $f->status));
        if ($f->employeeId) $query->where('employee_id', $f->employeeId);
    }

}
