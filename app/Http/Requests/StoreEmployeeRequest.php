<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the economic group store request
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "email" => "required|unique:employees,email|email",
            "cpf" => [
                "required",
                "regex:/^\d{11}$|^\d{3}\.\d{3}\.\d{3}\-\d{2}$/",
                "unique:employees,cpf"
            ],
            "unit_id" => "required|exists:units,id",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email precisa estar em formato adequado.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.regex' => 'O campo CPF precisa estar em formato adequado.',
            'cpf.unique' => 'Já existe colaborador com este mesmo CPF.',
            'unit_id.required' => 'O campo de unidade é obrigatório.',
            'unit_id.exists' => 'Esta unidade não existe.'
        ];
    }
}
