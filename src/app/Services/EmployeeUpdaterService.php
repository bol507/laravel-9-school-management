<?php
namespace App\Services;

use App\DTO\EmployeeDTO;
use App\Models\EmployeeSalaryChange;
use App\Models\User;
use App\Repositories\EmployeeRepository;
use App\Services\Contracts\ImageBbUploaderInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class EmployeeUpdaterService
{
    private EmployeeRepository $repository;
    private ImageBbUploaderInterface $imageUploader;

    public function __construct(
        EmployeeRepository $repository,
        ImageBbUploaderInterface $imageUploader
    ) {
        $this->repository = $repository;
        $this->imageUploader = $imageUploader;
    }

    public function execute(
        string $employeeId,
        EmployeeDTO $data,
        ?UploadedFile $image = null
    ): User {
        return DB::transaction(function () use ($employeeId, $data, $image) {

            $user = $this->repository->findById($employeeId);

            if (!$user) {
                throw new ModelNotFoundException("Employee with ID {$employeeId} not found.");
            }
            // 1. table users
            $user->update(['name' => $data->name]);

            // 2. table Profiles
            $profile = $user
                            ->profile()
                            ->firstOrFail();
            // Handle image upload if a new image is provided
            if ($image && !$data->imagePath) {
                try{
                    $data->imagePath = $this->imageUploader->upload($image);
                } catch (RuntimeException $e) {
                    throw new RuntimeException("Failed to upload image: " . $e->getMessage());
                }
            }



            $profile->fill([
                'father_name'    => $data->fatherName,
                'mother_name'    => $data->motherName,
                'mobile'         => $data->mobile,
                'address'        => $data->address,
                'gender'         => $data->gender,
                'religion'       => $data->religion,
                'date_birth'     => $data->dateBirth,
                'date_join'      => $data->dateJoin,
                'salary'         => $data->salary,
                'designation_id' => $data->designationId,
                'image_path'     => $data->imagePath ?? $profile->image_path,
            ]);
            $profile->save();

            // 3. table EmployeeSalaryChanges
            if ($data->salary !== null) {
                $currentSalary = $profile->getOriginal('salary'); // Get the original salary before update
                // Only update salary track if the salary has changed
                if (number_format($currentSalary ?? 0, 2, '.', '') !== number_format($data->salary, 2, '.', '')) {
                    $this->updateSalaryTrack(
                        employeeId: $employeeId,
                        newSalary: $data->salary,
                        effectiveDate: $data->dateJoin ?? now()
                    );
                }
            }

            return $user->fresh();
        });
    }

    /**
     *
     *
     * @param integer $employeeId
     * @param float $newSalary
     * @param Carbon $effectiveDate
     * @return void
     */
    private function updateSalaryTrack(string $employeeId, float $newSalary, Carbon $effectiveDate): void
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
