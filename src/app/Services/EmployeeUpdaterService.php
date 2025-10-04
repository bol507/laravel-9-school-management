<?php
namespace App\Services;

use App\DTO\EmployeeDTO;
use App\Models\EmployeeSalaryChange;
use App\Models\User;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Contracts\EmployeeCreatorServiceInterface;
use App\Services\Contracts\EmployeeUpdaterServiceInterface;
use App\Services\Contracts\ImageUploaderInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class EmployeeUpdaterService implements EmployeeUpdaterServiceInterface
{
    private EmployeeRepositoryInterface $repository;
    private ImageUploaderInterface $imageUploader;

    public function __construct(
        EmployeeRepositoryInterface $repository,
        ImageUploaderInterface $imageUploader
    ) {
        $this->repository = $repository;
        $this->imageUploader = $imageUploader;
    }

    public function execute(
        string $id,
        EmployeeDTO $data,
        ?UploadedFile $image = null
    ): User {
        return DB::transaction(function () use ($id, $data, $image) {

            $existingUser = $this->repository->findById($id);

            if (!$existingUser) {
                throw new ModelNotFoundException("Employee with ID {$id} not found.");
            }

            $userData = [
                'name' => $data->name,
            ];

            $profileData =[
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
            ];

            if ($image) {
                try {
                    $profileData['image_path'] = $this->imageUploader->upload($image);
                } catch (RuntimeException $e) {
                    throw new RuntimeException("Failed to upload image: " . $e->getMessage());
                }
            } else {
                // keep actual image.
                $profileData['image_path'] = $existingUser->profile->image_path;
            }

            $userUpdated = $this->repository->updateEmployee($id,$userData,$profileData);
            return $userUpdated;
        });
    }


}
