<?php


namespace App\Factories;

use App\Models\Profile;
use App\Models\User;

class ProfileStudentFactory
{
    public  function updateOrCreate($userId, $validated){
        
        $existingProfile = Profile::where('user_id', $userId)->first();

        $studentNo = $existingProfile ? $existingProfile->student_no : $this->generateStudentCode(User::where('user_type', 'student')->count() + 1);
        $code = $existingProfile ? $existingProfile->code : rand(0000, 9999);

        $updateData = [
            'student_no' => $studentNo,
            'code' => $code,
            'father_name' => $validated['father_name'],
            'mother_name' => $validated['mother_name'],
            'mobile' => $validated['mobile'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
            'religion' => $validated['religion'],
            'date_birth' => $validated['date_birth'],
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