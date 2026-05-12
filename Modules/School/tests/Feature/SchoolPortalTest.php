<?php

namespace Modules\School\Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\School\Models\AcademicProgram;
use Tests\TestCase;

class SchoolPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_portal_redirects_guests_to_login(): void
    {
        $response = $this->get(route('school.portal'));

        $response->assertRedirect(route('login'));
    }

    public function test_portal_is_accessible_to_authenticated_user(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('school.portal'));

        $response->assertOk();
        $response->assertViewIs('school::portal');
    }

    public function test_portal_view_has_required_data(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        AcademicProgram::factory()->count(2)->create(['is_public' => true]);
        $user = User::factory()->create();
        $user->assignRole('teacher');

        $response = $this->actingAs($user)->get(route('school.portal'));

        $response->assertOk();
        $response->assertViewHas('module');
        $response->assertViewHas('records');
        $response->assertViewHas('user');
    }

    public function test_portal_user_is_passed_to_view(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $user = User::factory()->create(['name' => 'Prof. Kabila']);
        $user->assignRole('teacher');

        $response = $this->actingAs($user)->get(route('school.portal'));

        $response->assertOk();
        $response->assertViewHas('user', fn ($u) => $u->is($user));
    }
}
