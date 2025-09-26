<?php

namespace App\Services;

use App\DTO\StudentDTO;
use App\Models\AssignStudent;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Services\Contracts\ImageUploaderInterface;
use App\Services\Contracts\StudentCreatorServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

final class StudentCreatorService implements StudentCreatorServiceInterface {

    private ImageUploaderInterface $imageUploader;
    private StudentRepositoryInterface $studentRepository;

    public function __construct(
        ImageUploaderInterface $imageUploader,
        StudentRepositoryInterface $studentRepository,
    ){
        $this->imageUploader = $imageUploader;
        $this->studentRepository = $studentRepository;
    }

    public function execute(StudentDTO $data, ?UploadedFile $image = null): AssignStudent {
        return DB::transaction(function() use ($data, $image){
            $imageUrl = null;
            if($image){
                try{
                    $imageUrl = $this->imageUploader->upload($image);
                }catch(RuntimeException $e){
                    throw new RuntimeException("Failed to upload image: " . $e->getMessage());
                }
            }

            $code = str_pad((string) random_int(0,9999),4,'0',STR_PAD_LEFT);
            $userData = [
                'name' => $data->name,
                'user_type' => 'student',
                'password' => Hash::make($code),
            ];
            //generate unique ID
            $studentCount = $this->studentRepository->countStudents();
            $idNo = $this->generateStudentCode($studentCount);

            // profile data
            $profileData = $data->toEloquent();
            $profileData['code'] = $code;
            $profileData['id_no'] = $idNo;
            $profileData['image_path'] = $imageUrl;

            //Assignation data
            $assignData = [
                'year_id' => $profileData['year_id'],
                'group_id' => $profileData['group_id'],
                'shift_id' => $profileData['shift_id'],
                'class_id' => $profileData['class_id'],
            ];


            return $this->studentRepository->createStudent(
                $userData,
                $profileData,
                $assignData,
                $data->discount ?? 0 
            );

        });
    }

    private function generateStudentCode($numberValue)
    {
        $number = (int)$numberValue;
        return 'STU' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
