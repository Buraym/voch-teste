<?php

namespace App\Http\Requests;

use App\Models\EconomicGroup;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEconomicGroupRequest extends FormRequest
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
            "name" => "required|unique:economic_groups,name",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.unique' => 'Já existe grupo com este mesmo nome'
        ];
    }
}
