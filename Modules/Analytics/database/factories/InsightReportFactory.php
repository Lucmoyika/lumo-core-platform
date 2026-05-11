<?php

namespace Modules\Analytics\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Analytics\Models\InsightReport;

class InsightReportFactory extends Factory
{
    protected $model = InsightReport::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Rapport croissance', 'Synthèse finance', 'Vue direction']);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'headline' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'active', 'active']),
            'audience' => 'Admin, managers et directions métier',
            'capabilities' => ['KPIs consolidés', 'Exports PDF / Excel', 'Suivi temps réel'],
            'metrics' => [
                'velocity' => fake()->numberBetween(60, 99),
                'satisfaction' => fake()->numberBetween(70, 100),
                'coverage' => fake()->numberBetween(50, 100),
            ],
            'is_public' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 50),
            'settings' => ['theme' => '#06b6d4', 'module' => 'analytics'],
        ];
    }
}
