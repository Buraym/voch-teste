<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
            "social" => "required",
            "cnpj" => `required|regex:\d{2}\.?\d{3}\.?\d{3}\/?\d{4}\-?\d{2}|unique:unity,cnpj`,
            "flag_id" => "required|exists:flags,id",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'social.required' => 'O campo razão social é obrigatório.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'cnpj.regex' => 'O campo CNPJ precisa estar em formato adequado.',
            'cnpj.unique' => 'Já existe unidade com este mesmo CNPJ.',
            'flag_id.required' => 'O campo de bandeira é obrigatório.',
            'flag_id.exists' => 'Esta bandeira não existe.'
        ];
    }
}
