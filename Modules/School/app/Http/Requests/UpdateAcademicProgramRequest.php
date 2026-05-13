<?php

namespace Modules\School\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicProgramRequest extends FormRequest
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
            'level' => ['required', 'in:maternelle,primaire,secondaire,professionnel'],
            'duration_months' => ['nullable', 'integer', 'min:1', 'max:72'],
            'annual_fee' => ['nullable', 'numeric', 'min:0'],
            'capabilities' => ['nullable', 'array'],
            'metrics' => ['nullable', 'array'],
            'is_public' => ['required', 'boolean'],
            'admission_open' => ['required', 'boolean'],
            'admission_deadline' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'settings' => ['nullable', 'array'],
        ];
    }
}
