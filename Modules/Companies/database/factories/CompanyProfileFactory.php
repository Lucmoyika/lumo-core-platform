<?php

namespace Modules\Companies\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Companies\Models\CompanyProfile;

class CompanyProfileFactory extends Factory
{
    protected $model = CompanyProfile::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Lumo Industries', 'Kivu Ventures', 'Africa Talent Hub']);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'headline' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'active', 'active']),
            'audience' => 'Administrateurs RH, recruteurs et managers',
            'capabilities' => ['Annuaire partenaires', 'Départements et postes', 'Suivi stages'],
            'metrics' => [
                'velocity' => fake()->numberBetween(60, 99),
                'satisfaction' => fake()->numberBetween(70, 100),
                'coverage' => fake()->numberBetween(50, 100),
            ],
            'is_public' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 50),
            'settings' => ['theme' => '#10b981', 'module' => 'companies'],
        ];
    }
}
