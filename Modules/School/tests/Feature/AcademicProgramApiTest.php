<?php

namespace Modules\School\Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\School\Models\AcademicProgram;
use Tests\TestCase;

class AcademicProgramApiTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        $this->seed(RolesAndPermissionsSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');

        return $user;
    }

    // ─── INDEX ───────────────────────────────────────────────────────────────

    public function test_api_index_returns_paginated_programmes(): void
    {
        AcademicProgram::factory()->count(5)->create();

        $response = $this->actingAs($this->adminUser(), 'sanctum')
            ->getJson('/api/v1/schools');

        $response->assertOk()
                 ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_api_index_requires_authentication(): void
    {
        $response = $this->getJson('/api/v1/schools');

        $response->assertUnauthorized();
    }

    // ─── STORE ───────────────────────────────────────────────────────────────

    public function test_admin_can_create_programme(): void
    {
        $response = $this->actingAs($this->adminUser(), 'sanctum')
            ->postJson('/api/v1/schools', [
                'name'        => 'Maternelle – Eveil 1',
                'headline'    => 'Premier cycle d\'éveil sensoriel et moteur',
                'description' => 'Programme complet pour l\'éveil des tout-petits de 3 à 5 ans.',
                'status'      => 'active',
                'audience'    => 'Enfants de 3 à 5 ans',
                'is_public'   => true,
            ]);

        $response->assertCreated()
                 ->assertJsonPath('data.name', 'Maternelle – Eveil 1')
                 ->assertJsonPath('data.status', 'active');

        $this->assertDatabaseHas('academic_programs', ['name' => 'Maternelle – Eveil 1']);
    }

    public function test_create_requires_mandatory_fields(): void
    {
        $response = $this->actingAs($this->adminUser(), 'sanctum')
            ->postJson('/api/v1/schools', []);

        $response->assertUnprocessable()
                 ->assertJsonValidationErrors(['name', 'headline', 'description', 'status', 'audience', 'is_public']);
    }

    // ─── SHOW ────────────────────────────────────────────────────────────────

    public function test_admin_can_read_programme(): void
    {
        $program = AcademicProgram::factory()->create();

        $response = $this->actingAs($this->adminUser(), 'sanctum')
            ->getJson("/api/v1/schools/{$program->id}");

        $response->assertOk()
                 ->assertJsonPath('data.id', $program->id)
                 ->assertJsonPath('data.name', $program->name);
    }

    public function test_show_returns_404_for_unknown_programme(): void
    {
        $response = $this->actingAs($this->adminUser(), 'sanctum')
            ->getJson('/api/v1/schools/99999');

        $response->assertNotFound();
    }

    // ─── UPDATE ──────────────────────────────────────────────────────────────

    public function test_admin_can_update_programme(): void
    {
        $program = AcademicProgram::factory()->create(['status' => 'draft']);

        $response = $this->actingAs($this->adminUser(), 'sanctum')
            ->putJson("/api/v1/schools/{$program->id}", [
                'name'        => $program->name.' (modifié)',
                'headline'    => $program->headline,
                'description' => $program->description,
                'status'      => 'active',
                'audience'    => $program->audience,
                'is_public'   => true,
            ]);

        $response->assertOk()
                 ->assertJsonPath('data.status', 'active');

        $this->assertDatabaseHas('academic_programs', [
            'id'     => $program->id,
            'status' => 'active',
        ]);
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────

    public function test_admin_can_delete_programme(): void
    {
        $program = AcademicProgram::factory()->create();

        $response = $this->actingAs($this->adminUser(), 'sanctum')
            ->deleteJson("/api/v1/schools/{$program->id}");

        $response->assertOk()
                 ->assertJsonPath('message', 'Deleted');

        $this->assertDatabaseMissing('academic_programs', ['id' => $program->id]);
    }

    // ─── WEB API (JSON) ──────────────────────────────────────────────────────

    public function test_index_returns_json_when_requested(): void
    {
        AcademicProgram::factory()->count(3)->create(['is_public' => true]);

        $response = $this->actingAs($this->adminUser(), 'sanctum')
            ->getJson('/api/v1/schools');

        $response->assertOk()
                 ->assertJsonCount(3, 'data');
    }
}
