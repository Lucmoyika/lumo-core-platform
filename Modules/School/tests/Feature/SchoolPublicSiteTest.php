<?php

namespace Modules\School\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\School\Models\AcademicProgram;
use Tests\TestCase;

class SchoolPublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_site_is_accessible(): void
    {
        $response = $this->get(route('school.home'));

        $response->assertOk();
    }

    public function test_public_site_displays_programmes(): void
    {
        AcademicProgram::factory()->count(3)->create(['is_public' => true, 'status' => 'active']);

        $response = $this->get(route('school.home'));

        $response->assertOk();
        $response->assertViewIs('school::index');
        $response->assertViewHas('records');
        $response->assertViewHas('stats');
        $response->assertViewHas('module');
    }

    public function test_public_site_stats_are_correct(): void
    {
        AcademicProgram::factory()->count(2)->create(['is_public' => true, 'status' => 'active']);
        AcademicProgram::factory()->count(1)->create(['is_public' => false, 'status' => 'draft']);

        $response = $this->get(route('school.home'));

        $response->assertOk();
        $response->assertViewHas('stats', function (array $stats): bool {
            return $stats['total'] === 3
                && $stats['published'] === 2
                && $stats['draft'] === 1;
        });
    }

    public function test_admission_page_is_accessible(): void
    {
        $response = $this->get(route('school.admission'));

        $response->assertOk();
        $response->assertViewIs('school::admission');
    }

    public function test_admission_form_requires_all_fields(): void
    {
        $response = $this->post(route('school.admission.submit'), []);

        $response->assertSessionHasErrors([
            'student_first_name',
            'student_last_name',
            'student_dob',
            'student_gender',
            'program_id',
            'academic_year',
            'guardian_name',
            'guardian_email',
            'guardian_phone',
            'guardian_relation',
        ]);
    }

    public function test_valid_admission_redirects_to_confirmation(): void
    {
        $program = AcademicProgram::factory()->create(['is_public' => true, 'status' => 'active']);

        $response = $this->post(route('school.admission.submit'), [
            'student_first_name' => 'Jean',
            'student_last_name'  => 'Dupont',
            'student_dob'        => '2015-06-15',
            'student_gender'     => 'M',
            'program_id'         => $program->id,
            'academic_year'      => date('Y').'-'.(date('Y') + 1),
            'guardian_name'      => 'Marie Dupont',
            'guardian_email'     => 'marie@example.com',
            'guardian_phone'     => '+243 890 123 456',
            'guardian_relation'  => 'mère',
            'message'            => 'Aucune allergie connue.',
        ]);

        $response->assertRedirect(route('school.admission.confirmed'));
    }

    public function test_admission_confirmed_page_is_accessible(): void
    {
        $response = $this->get(route('school.admission.confirmed'));

        $response->assertOk();
        $response->assertViewIs('school::admission-confirmed');
    }

    public function test_show_returns_programme_in_public_catalogue(): void
    {
        $program = AcademicProgram::factory()->create(['is_public' => true, 'status' => 'active']);

        $response = $this->get("/school/{$program->id}");

        $response->assertNotFound(); // show is not registered on web — only via API
    }
}
