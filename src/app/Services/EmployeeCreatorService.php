<?php

namespace App\Services;

use App\DTO\EmployeeDTO;
use App\Models\EmployeeSalaryChange;
use App\Models\User;
use App\Services\Contracts\ImageBbUploaderInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

final class EmployeeCreatorService
{

    private ImageBbUploaderInterface $imageUploader;

    public function __construct(
        ImageBbUploaderInterface $imageUploader
    ) {
        $this->imageUploader = $imageUploader;
    }

    public function execute(EmployeeDTO $data, ?UploadedFile $image = null): User {
        return DB::transaction(function () use ($data, $image) {
            // 1. Upload image if provided
            $imageUrl = null;
            if ($image) {
                try {
                    $imageUrl = $this->imageUploader->upload($image);
                } catch (RuntimeException $e) {
                    //
                    throw new RuntimeException("Failed to upload image: " . $e->getMessage());
                }
            }

            // 2. Create user
            $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $user = User::create([
                'name' => $data->name,
                'user_type' => 'employee',
                'password' => Hash::make($code),
            ]);

            // 3. Create profile
            $profileData = $data->toEloquent();
            $profileData['code'] = $code;
            $profileData['id_no'] = $this->generateEmployeeCode(User::where('user_type', 'employee')->count());
            $profileData['image_path'] = $imageUrl;
            $user->profile()->create($profileData);

            // 4. Create initial salary change record
            if ($data->salary !== null) {
                EmployeeSalaryChange::create([
                    'employee_id' => $user->id,
                    'previous_salary' => 0,
                    'present_salary' => $data->salary,
                    'increment_salary' => $data->salary, // initial salary
                    'effective_date' => $data->dateJoin ?? now(),
                ]);
            }

            return $user->load('profile');
        });
    }

    private function generateEmployeeCode($numberValue)
    {
        $number = (int)$numberValue;
        return 'EMP' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
