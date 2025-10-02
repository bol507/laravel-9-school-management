<?php

namespace App\Repositories;

use App\DTO\SalaryDTO;
use App\Models\EmployeeSalaryChange;
use App\Repositories\Contracts\SalaryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

final class SalaryRepository implements SalaryRepositoryInterface
{
    private function baseQuery(){
        return EmployeeSalaryChange::with('user')->whereHas('user', function ($q){
            $q->where('user_type', '=', 'employee');
        });
    }

    public function all(): Collection {
        return $this->baseQuery()->get();
    }

    public function findById(string $id): ?EmployeeSalaryChange {
        return $this->baseQuery()->find($id);
    }

    public function getSalaryHistoryByEmployeeId(string $employeeId): Collection
    {
        $salaryChanges = $this->baseQuery()
        ->where('employee_id', $employeeId)
        ->orderBy('effective_date', 'desc')
        ->get();

    return $salaryChanges->map(fn (EmployeeSalaryChange $salary) => $this->toDTO($salary));
    }

    public function findOrFail(string $id): EmployeeSalaryChange {
        $model = $this->findById($id);
        if(!$model){
            throw new ModelNotFoundException("Employee with ID {$id} not found.");
        }
        return $model;
    }

    public function findDTOOrFail(string $id): SalaryDTO {
        $salary = $this->findOrFail($id);
        return $this->toDTO($salary);
    }

    public function paginate(
        int $perPage = 10,
        ?string $search = null,
        array $filters = [],
        string $orderBy ='created_at',
        string $orderDirecction ='desc',
    ): LengthAwarePaginator {
        $query = $this->baseQuery();

        if(!empty($search)){
            $query->where( function ($q) use($search){
                $q->whereHas('user', function ($q) use ($search){
                    $q->where('name','LIKE', "%{$search}%");
                });
            });
        }

        foreach($filters as $key => $value){
            if($value !== null && $value !== ''){
                $query->where($key,$value);
            }
        }

        $allowedColumns = ['name','created_at'];
        if (!in_array($orderBy, $allowedColumns, true)){
            $orderBy = 'created_at';
        }

        $orderDirecction = strtolower($orderDirecction) === 'desc' ? 'desc' : 'asc';

        $paginator = $query
            ->orderBy($orderBy, $orderDirecction)
            ->paginate($perPage);

        $dtoCollection = $paginator
            ->getCollection()
            ->map( fn (EmployeeSalaryChange $salary) => $this->toDTO($salary));

        return $paginator->setCollection($dtoCollection);
    }

    public function createSalaryChange(array $data): EmployeeSalaryChange
    {
        return EmployeeSalaryChange::create($data);
    }


    private function toDTO(EmployeeSalaryChange $salary): SalaryDTO {
        return new SalaryDTO([
            'id'                => $salary->id,
            'employeeId'        => $salary->employee_id,
            'previousSalary'    => $salary->previous_salary,
            'presentSalary'     => $salary->present_salary,
            'incrementSalary'   => $salary->increment_salary,
            'effectiveDate'     => $salary->effective_date,
            'createdAt'         => $salary->created_at,
        ]);
    }
}
