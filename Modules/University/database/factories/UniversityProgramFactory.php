<?php

namespace Modules\University\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\University\Models\UniversityProgram;

class UniversityProgramFactory extends Factory
{
    protected $model = UniversityProgram::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Licence Informatique', 'Master Finance', 'Doctorat Education']);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'headline' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'active', 'active']),
            'audience' => 'Étudiants, enseignants et administration universitaire',
            'capabilities' => ['Parcours LMD', 'Calendrier académique', 'Recherche & thèses'],
            'metrics' => [
                'velocity' => fake()->numberBetween(60, 99),
                'satisfaction' => fake()->numberBetween(70, 100),
                'coverage' => fake()->numberBetween(50, 100),
            ],
            'is_public' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 50),
            'settings' => ['theme' => '#3b82f6', 'module' => 'university'],
        ];
    }
}
