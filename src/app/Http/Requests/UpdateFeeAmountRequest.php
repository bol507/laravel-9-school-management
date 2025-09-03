<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeAmountRequest extends FormRequest
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
            'fee_category_id' => 'required|exists:fee_categories,id', 
            'class_id' => 'required|array', 
            'class_id.*' => 'exists:student_classes,id', 
            'amount' => 'required|array', 
            'amount.*' => 'numeric|min:0', 
        ];
    }

     public function messages()
    {
        return [
            'fee_category_id.required' => 'The fee category is required.',
            'fee_category_id.exists' => 'The selected fee category is invalid.',
            'class_id.required' => 'At least one class must be selected.',
            'class_id.array' => 'Class IDs must be an array.',
            'class_id.*.exists' => 'One or more selected classes are invalid.',
            'amount.required' => 'Amounts are required for each class.',
            'amount.array' => 'Amounts must be an array.',
            'amount.*.numeric' => 'Each amount must be a valid number.',
            'amount.*.min' => 'Each amount must be at least 0.',
        ];
    }
}
