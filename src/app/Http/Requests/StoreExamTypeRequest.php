<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamTypeRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:exam_types,name', 
            'description' => 'nullable|string|max:250',
        ];
    }

     public function messages()
    {
        return [
            'name.required' => 'The exam type name is required.',
            'name.string' => 'The exam type name must be a string.',
            'name.max' => 'The exam type name may not be greater than 50 characters.',
            'name.unique' => 'The exam type name has already been taken.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 250characters.',
        ];
    }
}
