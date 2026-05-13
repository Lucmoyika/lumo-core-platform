<?php

namespace Modules\School\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\School\Models\AcademicProgram;
use Modules\School\Models\SchoolClass;

class SchoolClassFactory extends Factory
{
    protected $model = SchoolClass::class;

    private static int $counter = 0;

    public function definition(): array
    {
        $levels = [
            'Maternelle 1' => ['M1', 'M2'],
            'Maternelle 2' => ['M1'],
            'Maternelle 3' => ['M1', 'M2'],
            '1ère Primaire' => ['A', 'B', 'C'],
            '2ème Primaire' => ['A', 'B'],
            '3ème Primaire' => ['A', 'B', 'C'],
            '4ème Primaire' => ['A', 'B'],
            '5ème Primaire' => ['A', 'B'],
            '6ème Primaire' => ['A', 'B'],
            '1ère Secondaire' => ['A', 'B'],
            '2ème Secondaire' => ['A', 'B'],
            '3ème Secondaire' => ['A', 'B'],
        ];

        $level = $this->faker->randomElement(array_keys($levels));
        $sections = $levels[$level];
        $section = $this->faker->randomElement($sections);

        return [
            'academic_program_id' => AcademicProgram::factory(),
            'name' => $level,
            'level' => $level,
            'section' => $section,
            'capacity' => $this->faker->numberBetween(25, 40),
            'room' => 'Salle ' . $this->faker->randomElement(['A', 'B', 'C', 'D']) . $this->faker->numberBetween(1, 12),
            'school_year' => '2025-2026',
            'status' => 'active',
            'settings' => ['color' => $this->faker->hexColor()],
        ];
    }
}
