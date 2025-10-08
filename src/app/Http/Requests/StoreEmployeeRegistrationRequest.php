<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for validating employee registration data.
 * Ensures incoming data meets business rules before creating a new employee.
 */
class StoreEmployeeRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Authorization logic can be added here (e.g., role checks).
        // For now, allow all authenticated users.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'designation_id' => 'required|exists:designations,id',
            'salary' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'religion' => 'nullable|string|max:50',
            'date_birth' => 'required|date',
            'date_join' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ];
    }

    /**
     * Get custom validation error messages.
     *
     * @return array<string, string>
     */
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
            'mobile.max' => 'Mobile number cannot exceed 20 characters.',

            'designation_id.required' => 'Designation is required.',
            'designation_id.exists' => 'Selected designation does not exist.',

            'salary.required' => 'Salary is required.',
            'salary.numeric' => 'Salary must be a numeric value.',
            'salary.min' => 'Salary must be at least 0.',

            'address.required' => 'Address is required.',
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address cannot exceed 255 characters.',

            'gender.required' => 'Gender is required.',
            'gender.string' => 'Gender must be a string.',
            'gender.in' => 'Select a valid gender (Male, Female, Other).',

            'religion.string' => 'Religion must be a string.',
            'religion.max' => 'Religion cannot exceed 50 characters.',

            'date_birth.required' => 'Date of birth is required.',
            'date_birth.date' => 'The date of birth format is invalid.',

            'date_join.required' => 'Date of joining is required.',
            'date_join.date' => 'The date of joining format is invalid.',

            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'Image size cannot exceed 2MB.',
        ];
    }

    /**
     * Transform the validated request data into an array compatible with EmployeeDTO.
     * This method maps snake_case input fields to camelCase DTO properties.
     *
     * @return array The mapped data ready for EmployeeDTO instantiation.
     */
    public function validatedForDto(): array
    {
        $data = $this->validated();

        return [
            'name'          => $data['name'] ?? null,
            'designationId' => $data['designation_id'] ?? null,
            'fatherName'    => $data['father_name'] ?? null,
            'motherName'    => $data['mother_name'] ?? null,
            'mobile'        => $data['mobile'] ?? null,
            'address'       => $data['address'] ?? null,
            'gender'        => $data['gender'] ?? null,
            'religion'      => $data['religion'] ?? null,
            'dateBirth'     => $data['date_birth'] ?? null,
            'dateJoin'      => $data['date_join'] ?? null,
            'salary'        => $data['salary'] ?? null,
        ];
    }
}
