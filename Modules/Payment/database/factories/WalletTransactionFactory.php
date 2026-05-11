<?php

namespace Modules\Payment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Payment\Models\WalletTransaction;

class WalletTransactionFactory extends Factory
{
    protected $model = WalletTransaction::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Paiement frais T1', 'Recharge wallet vendor', 'Remboursement commande #42']);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'headline' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement(['draft', 'active', 'active']),
            'audience' => 'Comptables, clients et administrateurs financiers',
            'capabilities' => ['Wallet omnicanal', 'Mobile money', 'Journal anti-fraude'],
            'metrics' => [
                'velocity' => fake()->numberBetween(60, 99),
                'satisfaction' => fake()->numberBetween(70, 100),
                'coverage' => fake()->numberBetween(50, 100),
            ],
            'is_public' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 50),
            'settings' => ['theme' => '#8b5cf6', 'module' => 'payment'],
        ];
    }
}
