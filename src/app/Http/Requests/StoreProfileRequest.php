<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow authenticated users to create their own profile
        return auth()->check(); 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'religion' => ['nullable', 'string', 'max:50'],
            'blood_group' => ['nullable', Rule::in(['a+', 'a-', 'b+', 'b-', 'o+', 'o-', 'ab+', 'ab-'])],
            'nationality' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
