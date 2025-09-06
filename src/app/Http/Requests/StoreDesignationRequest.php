<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignationRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:designations,name', 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Designation  name is required.',
            'name.string' => 'Designation  name must be a string.',
            'name.max' => 'Designation  name may not be greater than 50 characters.',
            'name.unique' => 'Designation name has already been taken.',
            
        ];
    }
}
