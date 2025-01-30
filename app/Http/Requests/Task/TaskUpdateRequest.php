<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'create_date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['выполнена', 'не выполнена'])],
            'priority' => ['required', Rule::in(['низкий', 'средний', 'высокий'])],
            'category' => ['required', 'string'],
        ];
    }
}
