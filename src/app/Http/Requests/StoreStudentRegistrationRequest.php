<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRegistrationRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'father_name'   => 'nullable|string|max:255',
            'mother_name'   => 'nullable|string|max:255',
            'mobile'        => 'nullable|string|max:15',
            'address'       => 'required|string|max:255',
            'gender'        => 'required|string|in:Male,Female,Other',
            'religion'      => 'nullable|string|max:50',
            'date_birth'    => 'required|date',
            'year_id'       => 'required|exists:student_years,id',
            'class_id'      => 'required|exists:student_classes,id',
            'group_id'      => 'nullable|exists:student_groups,id',
            'shift_id'      => 'required|exists:student_shifts,id',
            'discount'      => 'nullable|numeric|min:0|max:100',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot exceed 255 characters.',

            'father_name.string' => 'Father\'s name must be a string.',
            'father_name.max' => 'Father\'s name cannot exceed 255 characters.',

            'mother_name.string' => 'Mother\'s name must be a string.',
            'mother_name.max' => 'Mother\'s name cannot exceed 255 characters.',

            'mobile.string' => 'Mobile number must be a string.',
            'mobile.max' => 'Mobile number cannot exceed 15 characters.',

            'address.required' => 'Address is required.',
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address cannot exceed 255 characters.',

            'gender.required' => 'Gender is required.',
            'gender.string' => 'Gender must be a string.',
            'gender.in' => 'Select a valid gender (male, female, other).',

            'religion.string' => 'Religion must be a string.',
            'religion.max' => 'Religion cannot exceed 50 characters.',

            'date_birth.required' => 'Date of birth is required.',
            'date_birth.date' => 'The date of birth format is invalid.',

            'year_id.required' => 'Year is required.',
            'year_id.exists' => 'The selected year is not valid.',

            'class_id.required' => 'Class is required.',
            'class_id.exists' => 'The selected class is not valid.',

            'group_id.exists' => 'The selected group is not valid.',

            'shift_id.required' => 'Shift is required.',
            'shift_id.exists' => 'The selected shift is not valid.',

            'discount.numeric' => 'Discount must be a number.',
            'discount.min' => 'Discount cannot be less than 0.',
            'discount.max' => 'Discount cannot be greater than 100.',

            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image cannot exceed 2MB.',
        ];
    }

    public function validatedForDto(): array {
        $data = $this->validated();
        return [
            'name'          => $data['name'] ?? null,
            'fatherName'    => $data['father_name'],
            'motherName'    => $data['mother_name'],
            'mobile'        => $data['mobile'],
            'address'       => $data['address'],
            'gender'        => $data['gender'],
            'religion'      => $data['religion'],
            'dateBirth'     => $data['date_birth'],
            'yearId'        => $data['year_id'], 
            'classId'       => $data['class_id'],
            'groupId'       => $data['group_id'],
            'shiftId'       => $data['shift_id'],
            'discount'      => $data['discount'],
        ];
    }
}
