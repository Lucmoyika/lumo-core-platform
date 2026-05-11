<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $admin = User::firstOrCreate(
            ['email' => 'admin@lumo.test'],
            [
                'name' => 'Super Admin',
                'password' => 'password',
                'locale' => 'fr',
                'is_active' => true,
            ]
        );

        $admin->assignRole('super-admin');

        User::factory(5)->create();
    }
}
