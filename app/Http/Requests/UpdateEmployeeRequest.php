<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'employee_hours' => ['required', 'numeric', 'min:0'],
        'extra_cost' => ['nullable', 'numeric', 'min:0'],  // nullable di sini
        'task_description' => ['required', 'string', 'min:5'],
        ];
    }
}
