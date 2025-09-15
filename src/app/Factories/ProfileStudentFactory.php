<?php


namespace App\Factories;

use App\Models\Profile;
use App\Models\User;

class ProfileStudentFactory
{
    public  function updateOrCreate($userId, $validated){
        
        $existingProfile = Profile::where('user_id', $userId)->first();

        $studentNo = $existingProfile ? $existingProfile->student_no : $this->generateStudentCode(User::where('user_type', 'student')->count() + 1);
        $code = $existingProfile 
            ? $existingProfile->code 
            : str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $updateData = [
            'student_no' => $studentNo,
            'code' => $code,
            'father_name' => $validated['father_name'] ?? null,
            'mother_name' => $validated['mother_name'] ?? null,
            'mobile' => $validated['mobile'] ?? null,
            'address' => $validated['address'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'date_birth' => $validated['date_birth'] ?? null,
        ];

        
        if (isset($validated['image'])) {
            $updateData['image'] = $validated['image'];
        } else {
            $updateData['image'] = $existingProfile ? $existingProfile->image : null;
        }

        
        $profile = Profile::updateOrCreate(
            ['user_id' => $userId], // match
            $updateData
        );

        return [
            'profile' => $profile,
            'code' => $code,
        ];
    }

    private function generateStudentCode($numberValue)
    {
        
        $number = (int)$numberValue;

        $code = 'STU' . str_pad($number, 6, '0', STR_PAD_LEFT);
        
        return $code;
    }
}