<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEconomicGroupReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the simple report store request
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "user_name" =>"required|string",
            "economic_groups" => 'required|array',
            'economic_groups.*' => 'exists:economic_groups,id',
            "flags" => 'required|array',
            'flags.*' => 'exists:flags,id',
            "units" => 'required|array',
            'units.*' => 'exists:units,id',
            "employees" => 'required|array',
            'employees.*' => 'exists:employees,id'
        ];
    }

    public function messages()
    {
        return [];
    }
}
