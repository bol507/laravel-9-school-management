<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalaryChangeRequest extends FormRequest
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
            'increment_amount' => 'required|numeric|min:0',
            'new_salary' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
        ];
    }

    public function messages(){
        return [
            'increment_amount.required' => 'The increment amount is required',
            'increment_amount.numeric' => 'The increment amount must be a number',
            'increment_amount.min' => 'The increment amount must be greater than or equal to zero',
            'new_salary.required' => 'The new salary is required',
            'new_salary.numeric' => 'The new salary must be a number',
            'new_salary.min' => 'The new salary must be greater than or equal to zero',
            'effective_date.required' => 'The effective date is required',
            'effective_date.date' => 'The effective date must be a valid date',
        ];
    }

    public function validatedForDto(): array
    {
        $data = $this->validated();
        return [
            'employeeId'   => $this->route('id'),
            'newSalary'     => $data['new_salary'] ?? null,
            'incrementSalary'   => $data['increment_amount'] ?? null,
            'effectiveDate'      => $data['effective_date'] ?? null,
        ];
    }
}
