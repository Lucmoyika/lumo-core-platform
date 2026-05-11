<?php

namespace Modules\University\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUniversityProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'headline' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'status' => ['required', 'in:draft,active,archived'],
            'audience' => ['required', 'string', 'max:255'],
            'capabilities' => ['nullable', 'array'],
            'metrics' => ['nullable', 'array'],
            'is_public' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'settings' => ['nullable', 'array'],
        ];
    }
}
