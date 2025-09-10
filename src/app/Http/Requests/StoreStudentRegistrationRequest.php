<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRegistrationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            //'email' => 'required|email|unique:users,email|max:255',
           // 'password' => 'required|string|min:8|',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,other',
            'religion' => 'required|string|max:50',
            'date_birth' => 'required|date',
            'year_id' => 'required|exists:student_years,id',
            'class_id' => 'required|exists:student_classes,id',
            'group_id' => 'nullable|exists:student_groups,id',
            'shift_id' => 'required|exists:student_shifts,id',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            
        /* 'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico es inválido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',*/
            
            'father_name.required' => 'El nombre del padre es obligatorio.',
            'father_name.string' => 'El nombre del padre debe ser una cadena de texto.',
            'father_name.max' => 'El nombre del padre no puede exceder los 255 caracteres.',
            
            'mother_name.required' => 'El nombre de la madre es obligatorio.',
            'mother_name.string' => 'El nombre de la madre debe ser una cadena de texto.',
            'mother_name.max' => 'El nombre de la madre no puede exceder los 255 caracteres.',
            
            'mobile.required' => 'El número de móvil es obligatorio.',
            'mobile.string' => 'El número de móvil debe ser una cadena de texto.',
            'mobile.max' => 'El número de móvil no puede exceder los 15 caracteres.',
            
            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'address.max' => 'La dirección no puede exceder los 255 caracteres.',
            
            'gender.required' => 'El género es obligatorio.',
            'gender.string' => 'El género debe ser una cadena de texto.',
            'gender.in' => 'Selecciona un género válido (masculino, femenino, otro).',
            
            'religion.required' => 'La religión es obligatoria.',
            'religion.string' => 'La religión debe ser una cadena de texto.',
            'religion.max' => 'La religión no puede exceder los 50 caracteres.',
            
            'date_birth.required' => 'La fecha de nacimiento es obligatoria.',
            'date_birth.date' => 'El formato de la fecha de nacimiento es inválido.',
            
            'year_id.required' => 'El año es obligatorio.',
            'year_id.exists' => 'El año seleccionado no es válido.',
            
            'class_id.required' => 'La clase es obligatoria.',
            'class_id.exists' => 'La clase seleccionada no es válida.',
            
            'group_id.exists' => 'El grupo seleccionado no es válido.',
            
            'shift_id.required' => 'El turno es obligatorio.',
            'shift_id.exists' => 'El turno seleccionado no es válido.',
            
            'discount.numeric' => 'El descuento debe ser un número.',
            'discount.min' => 'El descuento no puede ser menor que 0.',
            'discount.max' => 'El descuento no puede ser mayor que 100.',
            
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
            'image.max' => 'La imagen no puede exceder los 2MB.',
        ];
    }
}
