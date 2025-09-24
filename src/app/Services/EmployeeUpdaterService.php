<?php
namespace App\Services;

use App\DTO\EmployeeDTO;
use App\Models\EmployeeSalaryChange;
use App\Models\User;
use App\Repositories\EmployeeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

final class EmployeeUpdaterService
{
    private EmployeeRepository $repository;

    public function __construct(
        EmployeeRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function execute(string $employeeId, EmployeeDTO $data): User
    {
        return DB::transaction(function () use ($employeeId, $data) {

            $user = $this->repository->findById($employeeId);

            if (!$user) {
                throw new ModelNotFoundException("Employee with ID {$employeeId} not found.");
            }
            // 1. table users
            $user->update(['name' => $data->name]);

            // 2. table Profiles
            $profile = $user->profile()
                            ->firstOrFail();


            if ($data->imagePath !== null) {
                //$this->uploader->delete($profile->image);  //imgBB dont delete api way
                $profile->image_path = $data->imagePath;
            }

            $profile->fill($data->toEloquent());
            $profile->save();

            // 3. table EmployeeSalaryChanges
            if ($data->salary !== null) {
               $this->updateSalaryTrack(
                    employeeId: $employeeId,
                    newSalary: $data->salary,
                    effectiveDate: $data->dateJoin ?? now()
                );
            }

            return $user->fresh();
        });
    }

    /**
     * Undocumented function
     *
     * @param integer $employeeId
     * @param float $newSalary
     * @param Carbon $effectiveDate
     * @return void
     */
    private function updateSalaryTrack(int $employeeId, float $newSalary, Carbon $effectiveDate): void
    {
        $existingRecord = EmployeeSalaryChange::where('employee_id', $employeeId)->first();

        $salaryChange = $existingRecord ?? new EmployeeSalaryChange();
        $salaryChange->employee_id = $employeeId;
        $salaryChange->previous_salary = $existingRecord?->present_salary ?? 0;
        $salaryChange->present_salary = $newSalary;
        $salaryChange->increment_salary = $newSalary - $salaryChange->previous_salary;
        $salaryChange->effective_date = $effectiveDate;

        $salaryChange->save();
    }
}
