<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeeAmountRequest extends FormRequest
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
            'class_id'        => 'required|array',
            'class_id.*'      => 'exists:student_classes,id',
            'amount'          => 'required|array',
            'amount.*'        => 'numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'fee_category_id.required' => 'category is required',
            'fee_category_id.exists'   => 'Category is not valid',
            'class_id.required'        => 'Class is required.',
            'class_id.*.exists'        => 'Class no exist',
            'amount.required'          => 'Amount is required',
            'amount.*.numeric'         => 'Amount is numeric',
            'amount.*.min'             => 'Amount is greater than 0',
        ];
    }
}
