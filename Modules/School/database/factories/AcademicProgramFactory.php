<?php

namespace Modules\School\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\School\Models\AcademicProgram;

class AcademicProgramFactory extends Factory
{
    protected $model = AcademicProgram::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Maternelle - Eveil 1', 'Primaire - 5e année', 'Humanités - Sciences']);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'headline' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'active', 'active']),
            'audience' => 'Admins école, enseignants, parents et élèves',
            'level' => fake()->randomElement(['maternelle', 'primaire', 'secondaire', 'professionnel']),
            'duration_months' => fake()->numberBetween(9, 48),
            'annual_fee' => fake()->randomFloat(2, 150, 1800),
            'capabilities' => ['Admissions en ligne', 'Structure académique', 'Bulletins & finances'],
            'metrics' => [
                'velocity' => fake()->numberBetween(60, 99),
                'satisfaction' => fake()->numberBetween(70, 100),
                'coverage' => fake()->numberBetween(50, 100),
            ],
            'is_public' => fake()->boolean(80),
            'admission_open' => fake()->boolean(70),
            'admission_deadline' => fake()->dateTimeBetween('now', '+6 months'),
            'sort_order' => fake()->numberBetween(1, 50),
            'settings' => ['theme' => '#6366f1', 'module' => 'school'],
        ];
    }
}
