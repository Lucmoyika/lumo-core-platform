<?php

namespace Tests\Feature\School;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\School\Database\Seeders\SchoolDatabaseSeeder;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Invoice;
use Tests\TestCase;

class ErpWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->seed(SchoolDatabaseSeeder::class);
    }

    public function test_admin_dashboard_and_fees_workflow_pages_are_accessible(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/school/erp/dashboard/admin')
            ->assertOk()
            ->assertSee('Admin Dashboard');

        $this->actingAs($user)
            ->get('/school/erp/fees')
            ->assertOk()
            ->assertSee('Gestion des frais');
    }

    public function test_report_card_pdf_export_returns_pdf_response(): void
    {
        $user = User::factory()->create();
        $enrollment = Enrollment::query()->firstOrFail();

        $response = $this->actingAs($user)
            ->get('/school/erp/report-cards/' . $enrollment->id . '/pdf?period=1er%20trimestre');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition');
    }

    public function test_invoice_generation_endpoint_creates_missing_invoices(): void
    {
        $user = User::factory()->create();

        Invoice::query()->delete();

        $this->actingAs($user)
            ->post('/school/erp/fees/generate-invoices')
            ->assertRedirect();

        $this->assertGreaterThan(0, Invoice::count());
    }
}
