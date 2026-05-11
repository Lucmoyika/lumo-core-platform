<?php

namespace Tests\Feature\Identity;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get(route('identity.login'));

        $response->assertOk();
    }

    public function test_user_can_register_and_is_redirected_to_dashboard(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $response = $this->post(route('identity.register.post'), [
            'name' => 'New User',
            'email' => 'new.user@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('identity.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_authenticated_user_can_open_dashboard(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('identity.dashboard'));

        $response->assertOk();
    }
}
