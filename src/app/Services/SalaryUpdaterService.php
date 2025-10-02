<?php

namespace App\Services;

use App\DTO\SalaryDTO;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\Contracts\SalaryRepositoryInterface;
use App\Services\Contracts\SalaryUpdaterServiceInterface;
use Illuminate\Support\Facades\DB;

final class SalaryUpdaterService implements SalaryUpdaterServiceInterface {
    private SalaryRepositoryInterface $repository;

    public function __construct(SalaryRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function execute(
        string $employeeId,
        SalaryDTO $data,
    ): void {
        DB::transaction(function () use ($employeeId, $data) {
                $user = User::findOrFail($employeeId);

                $salaryData =[
                    'employee_id' => $employeeId,
                    'previous_salary' => $user->profile->salary,
                    'present_salary' => $data->newSalary,
                    'increment_salary' => $data->incrementSalary,
                    'effective_date' => $data->effectiveDate,
                ];

                $this->repository->createSalaryChange($salaryData);

                $profile = Profile::where('user_id', $employeeId)->first();
                if($profile){
                    $profile->salary = $data->newSalary;
                    $profile->save();
                }

        });
    }
}
