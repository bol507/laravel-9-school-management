<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolSubjectRequest extends FormRequest
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
            'name' =>'required|string|max:50|unique:school_subjects,name',
        ];
    }

    public function messages(){
        return[
            'name.required'=>'School subject name is required',
            'name.unique'=>'School subject already exist',
            'name.max'=>'School subject name should not be greater than 50 characters', 
            'name.string'=>'School subject must be a string',
        ];
    }
}
