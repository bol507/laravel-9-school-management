<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStudentClassRequest extends FormRequest
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
            'name' => 'bail|required|string|min:3|max:255|unique:student_classes,name',
        ];
    }

    
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 3 characters.',
            'name.max' => 'Name must be at most 255 characters.',
            'name.unique' => 'Name is already taken.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->input('name'))) {
            $normalized = trim(preg_replace('/\s+/', ' ', $this->input('name')));
            $this->merge(['name' => $normalized]);
        }
    }
}
