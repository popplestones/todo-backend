<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tasks', 'name')
                    ->where('user_id', auth()->id())
                    ->ignore($this->route('task'))
            ],
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ];
    }
}
