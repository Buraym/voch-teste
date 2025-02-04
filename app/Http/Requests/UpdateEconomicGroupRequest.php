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
        $economicGroup = EconomicGroup::find($this->route('group'));
        return $economicGroup && $this->user()->can('update', $economicGroup);
    }

    /**
     * Get the validation rules that apply to the economic group store request
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|unique",
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
