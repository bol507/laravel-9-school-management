<?php
namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Listable
{
    /**
     * Returns the name of the Eloquent model to be used.
     * For example: AssignStudent::class
     */
    abstract protected function listableModel(): string;

    /**
     * Relationships that will always be loaded.
     * For example: ['user', 'profile']
     */
    protected function listableWith(): array
    {
        return [];
    }

    /**
     * Columns that can be searched (only LIKE).
     * For example: ['users.name']
     */
    protected function listableSearchColumns(): array
    {
        return [];
    }

    /**
     * Exact filters that come via query string.
     * For example: ['year_id', 'class_id']
     */
    protected function listableFilters(): array
    {
        return [];
    }

    /**
     * Default column for ordering.
     */
    protected function listableOrderBy(Request $request): string
    {
        return $request->input('order_by', 'id');
    }

    /**
     * Limit of items per page (max 100).
     */
    protected function perPage(Request $request): int
    {
        return max(1, min((int) $request->input('limit', 10), 100));
    }

    /**
     * Applies the LIKE search to the defined columns.
     */
    protected function applySearch(Builder $query, ?string $search): Builder
    {
        if (blank($search)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search) {
            foreach ($this->listableSearchColumns() as $column) {
                // Supports relationships: user.name
                if (str_contains($column, '.')) {
                    [$relation, $field] = explode('.', $column, 2);
                    $q->orWhereHas($relation, fn($q) => $q->where($field, 'LIKE', "%{$search}%"));
                } else {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            }
        });
    }

    /**
     * Applies exact filters.
     */
    protected function applyFilters(Builder $query, Request $request): Builder
    {
        foreach ($this->listableFilters() as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }
        return $query;
    }

    /**
     * Executes the query and returns the paginator.
     */
    protected function list(Request $request)
    {
        $query = $this->listableModel()::with($this->listableWith());

        $query = $this->applySearch($query, trim($request->input('search') ?? ''));
        $query = $this->applyFilters($query, $request);

        $raw = (string) $this->listableOrderBy($request);
        $direction = 'asc';
        // support "-col" or "col desc"
        if (str_starts_with($raw, '-')) {
            $direction = 'desc';
            $raw = ltrim($raw, '-');
        } elseif (preg_match('/\s+(asc|desc)\s*$/i', $raw, $m)) {
            $direction = strtolower($m[1]);
            $raw = trim(substr($raw, 0, -strlen($m[1])));
        }
        $column = trim($raw);
        $allowed = method_exists($this, 'listableSortable') ? $this->listableSortable() : ['id'];
        if (!in_array($column, $allowed, true)) {
            $column = $allowed[0] ?? 'id';
        }
        $query->orderBy($column, $direction);

        return $query
            ->paginate($this->perPage($request))
            ->appends($request->query());
    }
}