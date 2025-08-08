<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'old_password' => 'required|string|current_password:web',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Old password is required.',
            'old_password.current_password' => 'The provided password does not match your current password.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ];
    }
}
