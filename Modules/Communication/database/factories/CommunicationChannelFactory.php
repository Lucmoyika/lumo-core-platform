<?php

namespace Modules\Communication\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Communication\Models\CommunicationChannel;

class CommunicationChannelFactory extends Factory
{
    protected $model = CommunicationChannel::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Canal annonces', 'Support parents', 'Briefing équipe']);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'headline' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'active', 'active']),
            'audience' => 'Utilisateurs, support et équipes de coordination',
            'capabilities' => ['Canaux privés/publics', 'Alertes instantanées', 'Journal conversationnel'],
            'metrics' => [
                'velocity' => fake()->numberBetween(60, 99),
                'satisfaction' => fake()->numberBetween(70, 100),
                'coverage' => fake()->numberBetween(50, 100),
            ],
            'is_public' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 50),
            'settings' => ['theme' => '#14b8a6', 'module' => 'communication'],
        ];
    }
}
