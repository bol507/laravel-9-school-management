<?php

namespace App\Http\Requests;

use App\DTO\EmployeeData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name'            => 'required|string|max:255',
            'designation_id'  => 'nullable|uuid|exists:designations,id',
            'father_name'     => 'nullable|string|max:255',
            'mother_name'     => 'nullable|string|max:255',
            'mobile'          => 'nullable|string|max:20',
            'address'         => 'nullable|string|max:500',
            'gender'          => 'nullable|in:male,female,other',
            'religion'        => 'nullable|string|max:50',
            'date_birth'      => 'nullable|date',
            'date_join'       => 'nullable|date',
            'salary'          => 'nullable|numeric|min:0',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function dto(string $employeeId): EmployeeData
    {
        return new EmployeeData(
            name: $this->validated('name'),
            designationId: $this->validated('designation_id'),
            fatherName: $this->validated('father_name'),
            motherName: $this->validated('mother_name'),
            mobile: $this->validated('mobile'),
            address: $this->validated('address'),
            gender: $this->validated('gender'),
            religion: $this->validated('religion'),
            dateBirth: $this->date('date_birth'),
            dateJoin: $this->date('date_join'),
            salary: $this->validated('salary'),
            imagePath: null,  // Image handling is done in the controller
        );
    }

}
