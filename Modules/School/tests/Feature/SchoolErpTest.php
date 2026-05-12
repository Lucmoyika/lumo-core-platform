<?php

namespace Modules\School\Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\School\Models\AcademicProgram;
use Tests\TestCase;

class SchoolErpTest extends TestCase
{
    use RefreshDatabase;

    public function test_erp_redirects_guests_to_login(): void
    {
        $response = $this->get(route('school.erp'));

        $response->assertRedirect(route('login'));
    }

    public function test_erp_is_accessible_to_admin(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('school.erp'));

        $response->assertOk();
        $response->assertViewIs('school::erp');
    }

    public function test_erp_view_has_stats_and_records(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        AcademicProgram::factory()->count(4)->create(['status' => 'active', 'is_public' => true]);
        AcademicProgram::factory()->count(2)->create(['status' => 'draft', 'is_public' => false]);

        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('school.erp'));

        $response->assertOk();
        $response->assertViewHas('stats');
        $response->assertViewHas('records');
        $response->assertViewHas('module');

        $response->assertViewHas('stats', function (array $stats): bool {
            return $stats['total'] === 6
                && $stats['published'] === 4
                && $stats['draft'] === 2;
        });
    }
}
