<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignSubjectRequest extends FormRequest
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
            'class_id' => 'required|uuid|exists:student_classes,id', // Class ID is required, must be a valid UUID, and must exist in the student_classes table.
            'subject_id' => 'required|array', // Subject IDs are required and must be an array.
            'subject_id.*' => 'uuid|exists:school_subjects,id', // Each subject ID must be a valid UUID and must exist in the school_subjects table.
            'full_mark' => 'required|array', // Full marks are required and must be an array.
            'full_mark.*' => 'required|numeric|min:0', // Each full mark must be required, numeric, and at least 0.
            'pass_mark' => 'required|array', // Pass marks are required and must be an array.
            'pass_mark.*' => 'required|numeric|min:0', // Each pass mark must be required, numeric, and at least 0.
            'subjective_mark' => 'required|array', // Subjective marks are required and must be an array.
            'subjective_mark.*' => 'required|numeric|min:0', // Each subjective mark must be required, numeric, and at least 0.
        ];
    }

    public function messages()
    {
        return [
            'class_id.required' => 'The class ID field is required.', // Class ID is required.
            'class_id.uuid' => 'The class ID must be a valid UUID.', // Class ID must be a valid UUID.
            'class_id.exists' => 'The selected class ID does not exist.', // Class ID must exist in the student_classes table.
            
            'subject_id.required' => 'The subject ID field is required.', // Subject ID is required.
            'subject_id.array' => 'The subject ID must be an array.', // Subject ID must be an array.
            
            'subject_id.*.uuid' => 'Each subject ID must be a valid UUID.', // Each subject ID must be a valid UUID.
            'subject_id.*.exists' => 'One or more selected subject IDs do not exist.', // Subject ID must exist in the school_subjects table.
            
            'full_mark.required' => 'The full mark field is required.', // Full mark is required.
            'full_mark.array' => 'The full mark must be an array.', // Full mark must be an array.
            
            'full_mark.*.required' => 'Each full mark is required.', // Each full mark is required.
            'full_mark.*.numeric' => 'Each full mark must be a number.', // Each full mark must be numeric.
            'full_mark.*.min' => 'Each full mark must be at least 0.', // Each full mark must be at least 0.
            
            'pass_mark.required' => 'The pass mark field is required.', // Pass mark is required.
            'pass_mark.array' => 'The pass mark must be an array.', // Pass mark must be an array.
            
            'pass_mark.*.required' => 'Each pass mark is required.', // Each pass mark is required.
            'pass_mark.*.numeric' => 'Each pass mark must be a number.', // Each pass mark must be numeric.
            'pass_mark.*.min' => 'Each pass mark must be at least 0.', // Each pass mark must be at least 0.
            
            'subjective_mark.required' => 'The subjective mark field is required.', // Subjective mark is required.
            'subjective_mark.array' => 'The subjective mark must be an array.', // Subjective mark must be an array.
            
            'subjective_mark.*.required' => 'Each subjective mark is required.', // Each subjective mark is required.
            'subjective_mark.*.numeric' => 'Each subjective mark must be a number.', // Each subjective mark must be numeric.
            'subjective_mark.*.min' => 'Each subjective mark must be at least 0.', // Each subjective mark must be at least 0.
        ];
    }
}
