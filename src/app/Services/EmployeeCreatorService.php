<?php

namespace App\Services;

use App\DTO\EmployeeDTO;
use App\Models\User;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Contracts\EmployeeCreatorServiceInterface;
use App\Services\Contracts\ImageUploaderInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

final class EmployeeCreatorService implements EmployeeCreatorServiceInterface
{

    private ImageUploaderInterface $imageUploader;
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(
        ImageUploaderInterface $imageUploader,
        EmployeeRepositoryInterface $employeeRepository,
    ) {
        $this->imageUploader = $imageUploader;
        $this->employeeRepository = $employeeRepository;
    }

    public function execute(EmployeeDTO $data, ?UploadedFile $image = null): User {
        return DB::transaction(function () use ($data, $image) {
            $imageUrl = null;
            if ($image) {
                try {
                    $imageUrl = $this->imageUploader->upload($image);
                } catch (RuntimeException $e) {
                    //
                    throw new RuntimeException("Failed to upload image: " . $e->getMessage());
                }
            }

            $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $userData = [
                'name' => $data->name,
                'user_type' => 'employee',
                'password' => Hash::make($code),
            ];

            $profileData = $data->toArray();
            $profileData['code'] = $code;
            $profileData['image_path'] = $imageUrl;

            $user = $this->employeeRepository->createEmployee(
                $userData,
                $profileData,
            );

            return $user;
        });
    }
}
