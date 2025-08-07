<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'mobile' => 'nullable|string|min:6|max:11',
            'address' => 'nullable|string|min:3|max:255',
            'religion' => 'nullable|string|min:3|max:255',
            'blood_group' => 'nullable|string|min:3|max:255',
            'nationality' => 'nullable|string|min:3|max:255',
            'gender' => ['required', 'in:male,female,other'],
            'status' => 'required|integer',
        ];
    }
}
