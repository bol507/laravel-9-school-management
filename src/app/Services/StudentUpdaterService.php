<?php

namespace App\Services;

use App\DTO\StudentDTO;
use App\Models\AssignStudent;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Services\Contracts\ImageUploaderInterface;
use App\Services\Contracts\StudentUpdaterServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class StudentUpdaterService implements StudentUpdaterServiceInterface
{
    private StudentRepositoryInterface $repository;
    private ImageUploaderInterface $imageUploader;

    public function __construct(
        StudentRepositoryInterface $repository,
        ImageUploaderInterface $imageUploader
    ){
        $this->repository = $repository;
        $this->imageUploader = $imageUploader;
    }
    
    public function execute (string $id, StudentDTO $data, ?UploadedFile $image = null) : AssignStudent {
       return DB::transaction(function() use ($id,$data,$image){
           
            $existingStudent = $this->repository->findById($id);
            if (!$existingStudent) {
                throw new RuntimeException("Student with ID {$id} not found.");
            }

            $userData = [
                'name' => $data->name,
            ];

            $profileData = [
                'gender'       => $data->gender,
                'father_name'  => $data->fatherName,
                'mother_name'  => $data->motherName,
                'mobile'       => $data->mobile,
                'address'      => $data->address,
                'religion'     => $data->religion,
                'date_birth'   => $data->dateBirth,
            ];

            if ($image) {
                try {
                    $profileData['image_path'] = $this->imageUploader->upload($image);
                } catch (RuntimeException $e) {
                    throw new RuntimeException("Failed to upload image: " . $e->getMessage());
                }
            } else {
                // Conservar la imagen actual (no la toques)
                $profileData['image_path'] = $existingStudent->profile->image_path ?? null;
            }
            
            $assignData = [
                'year_id'   => $data->yearId,
                'group_id'  => $data->groupId,
                'shift_id'  => $data->shiftId,
                'class_id'  => $data->classId,
            ];

            return $this->repository->updateStudent(
                $id,
                $userData,
                $profileData,
                $assignData,
                $data->discount ?? 0
            );
       });
    }
}
