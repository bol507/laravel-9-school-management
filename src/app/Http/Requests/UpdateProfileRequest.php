<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'mobile'        => ['nullable', 'string', 'max:20'],
            'address'       => ['nullable', 'string', 'max:255'],
            'gender'       => ['nullable', Rule::in(['male', 'female', 'other'])],
            'religion'       => ['nullable', 'string', 'max:50'],
            'blood_group'   => ['nullable', Rule::in(['a+', 'a-', 'b+', 'b-', 'o+', 'o-', 'ab+', 'ab-'])],
            'nationality'    => ['nullable', 'string', 'max:50'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status'      => ['nullable', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'gender.in'      => 'Gender must be either male, female or other.',
            'blood_group.in' => 'Blood group must be either a+, a-, b+, b-, o+, o-, ab+ or ab-.',
            'status.in'      => 'The status must be either active or inactive.',
            'image.image'    => 'The file must be an image.',
            'image.mimes'    => 'The file must be a JPG, JPEG, PNG.',
            'image.max'      => 'The file must be less than 2MB.',
        ];
    }
}
