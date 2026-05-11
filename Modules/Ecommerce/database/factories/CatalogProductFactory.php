<?php

namespace Modules\Ecommerce\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Ecommerce\Models\CatalogProduct;

class CatalogProductFactory extends Factory
{
    protected $model = CatalogProduct::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Pack scolaire premium', 'Abonnement SaaS annuel', 'Kit logistique connecté']);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'headline' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'active', 'active']),
            'audience' => 'Clients, vendeurs et équipe opérations',
            'capabilities' => ['Catalogue vendeur', 'Commandes et wishlist', 'Coupons promotionnels'],
            'metrics' => [
                'velocity' => fake()->numberBetween(60, 99),
                'satisfaction' => fake()->numberBetween(70, 100),
                'coverage' => fake()->numberBetween(50, 100),
            ],
            'is_public' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 50),
            'settings' => ['theme' => '#f43f5e', 'module' => 'ecommerce'],
        ];
    }
}
