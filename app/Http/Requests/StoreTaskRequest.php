<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_name'        => ['required', 'string', 'max:255'],
            'task_date'        => ['required', 'date'],
            'task_description' => ['required', 'string'],
            'extra_cost'       => ['nullable', 'numeric'],
            'employee_name'    => ['required', 'string', 'max:255'],
            'employee_hours'   => ['required', 'numeric'],
            'employee_rate'    => ['required', 'numeric'],
        ];
    }
}
