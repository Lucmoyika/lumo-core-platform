<?php

namespace Modules\Logistics\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Logistics\Models\DeliveryShipment;

class DeliveryShipmentFactory extends Factory
{
    protected $model = DeliveryShipment::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Livraison Goma #1001', 'Expédition campus sud', 'Retour fournisseur RDC']);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'headline' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'active', 'active']),
            'audience' => 'Clients, dispatchers et chauffeurs',
            'capabilities' => ['Tracking colis', 'Gestion tournées', 'Cartographie opérations'],
            'metrics' => [
                'velocity' => fake()->numberBetween(60, 99),
                'satisfaction' => fake()->numberBetween(70, 100),
                'coverage' => fake()->numberBetween(50, 100),
            ],
            'is_public' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 50),
            'settings' => ['theme' => '#f97316', 'module' => 'logistics'],
        ];
    }
}
