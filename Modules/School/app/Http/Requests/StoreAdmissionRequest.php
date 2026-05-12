<?php

namespace Modules\School\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_first_name' => ['required', 'string', 'max:100'],
            'student_last_name'  => ['required', 'string', 'max:100'],
            'student_dob'        => ['required', 'date', 'before:today'],
            'student_gender'     => ['required', 'in:M,F'],
            'program_id'         => ['required', 'integer', 'exists:academic_programs,id'],
            'academic_year'      => ['required', 'string', 'max:20'],
            'guardian_name'      => ['required', 'string', 'max:200'],
            'guardian_email'     => ['required', 'email', 'max:255'],
            'guardian_phone'     => ['required', 'string', 'max:30'],
            'guardian_relation'  => ['required', 'in:père,mère,tuteur,autre'],
            'message'            => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'student_first_name' => 'prénom de l\'élève',
            'student_last_name'  => 'nom de l\'élève',
            'student_dob'        => 'date de naissance',
            'student_gender'     => 'sexe',
            'program_id'         => 'programme',
            'academic_year'      => 'année scolaire',
            'guardian_name'      => 'nom du parent/tuteur',
            'guardian_email'     => 'email du parent/tuteur',
            'guardian_phone'     => 'téléphone du parent/tuteur',
            'guardian_relation'  => 'lien de parenté',
            'message'            => 'message complémentaire',
        ];
    }
}
