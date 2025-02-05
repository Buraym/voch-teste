<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlagRequest extends FormRequest
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
            "name" => "required|unique:flags,name",
            "economic_group_id" => "required|exists:economic_groups,id",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.unique' => 'Já existe grupo com este mesmo nome.',
            'economic_group_id.required' => 'O campo de grupo econômico é obrigatório.',
            'economic_group_id.exists' => 'Este grupo econômico não existe.'
        ];
    }
}
