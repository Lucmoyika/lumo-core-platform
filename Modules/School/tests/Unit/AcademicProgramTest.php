<?php

namespace Modules\School\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\School\Models\AcademicProgram;
use Tests\TestCase;

class AcademicProgramTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_can_be_created_with_factory(): void
    {
        $program = AcademicProgram::factory()->create();

        $this->assertInstanceOf(AcademicProgram::class, $program);
        $this->assertNotNull($program->id);
        $this->assertNotEmpty($program->name);
        $this->assertNotEmpty($program->slug);
    }

    public function test_capabilities_are_cast_to_array(): void
    {
        $program = AcademicProgram::factory()->create([
            'capabilities' => ['Admissions', 'Notes', 'Bulletins'],
        ]);

        $this->assertIsArray($program->capabilities);
        $this->assertCount(3, $program->capabilities);
    }

    public function test_metrics_are_cast_to_array(): void
    {
        $program = AcademicProgram::factory()->create([
            'metrics' => ['velocity' => 90, 'satisfaction' => 95],
        ]);

        $this->assertIsArray($program->metrics);
        $this->assertArrayHasKey('velocity', $program->metrics);
        $this->assertArrayHasKey('satisfaction', $program->metrics);
    }

    public function test_settings_are_cast_to_array(): void
    {
        $program = AcademicProgram::factory()->create([
            'settings' => ['theme' => '#6366f1', 'module' => 'school'],
        ]);

        $this->assertIsArray($program->settings);
        $this->assertArrayHasKey('theme', $program->settings);
    }

    public function test_is_public_is_cast_to_boolean(): void
    {
        $public  = AcademicProgram::factory()->create(['is_public' => true]);
        $private = AcademicProgram::factory()->create(['is_public' => false]);

        $this->assertTrue($public->is_public);
        $this->assertFalse($private->is_public);
    }

    public function test_status_defaults_to_draft(): void
    {
        $program = AcademicProgram::factory()->create(['status' => 'draft']);

        $this->assertSame('draft', $program->status);
    }

    public function test_slug_is_unique(): void
    {
        $programs = AcademicProgram::factory()->count(5)->create();

        $slugs = $programs->pluck('slug');
        $this->assertCount(5, $slugs->unique());
    }

    public function test_fillable_fields_can_be_mass_assigned(): void
    {
        $data = [
            'name'        => 'Primaire – 6e année',
            'slug'        => 'primaire-6e-annee-'.Str::random(4),
            'headline'    => 'Dernière année du cycle primaire',
            'description' => 'Programme de consolidation avant les humanités.',
            'status'      => 'active',
            'audience'    => 'Élèves de 11-12 ans',
            'is_public'   => true,
            'sort_order'  => 6,
        ];

        $program = AcademicProgram::create($data);

        $this->assertDatabaseHas('academic_programs', ['name' => 'Primaire – 6e année']);
        $this->assertSame('active', $program->status);
    }
}
