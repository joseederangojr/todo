<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', [$this->task, $this->space]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'string',
            'status' => 'in:triage,todo,doing,done,abandon',
            'assigned_to_id' => 'sometimes|nullable|exists:users,id',
            'due_date' => 'date|nullable',
            'space_column_id' => Rule::exists('space_columns', 'id')->where(
                'space_id',
                $this->space->id
            ),
        ];
    }
}
