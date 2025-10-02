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
            'increment_amount' => 'The increment amount must be a number and greater than zero',
            'new_salary' => 'The new salary must be a number and greater than zero',
            'effective_date.required' => 'The effective date is required',
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
