<?php

namespace Tests\Feature;

use App\Models\DonationIntent;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_project_management(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@dedefund.local')->firstOrFail();

        $response = $this->actingAs($admin)->get(route('admin.projects.index'));

        $response
            ->assertOk()
            ->assertSee('Projects')
            ->assertSee('Nyonu Zazin');
    }

    public function test_admin_can_update_project_content(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@dedefund.local')->firstOrFail();
        $project = Project::with('translations')->firstOrFail();

        $response = $this->actingAs($admin)->put(route('admin.projects.update', $project), [
            'intervention_area_id' => $project->intervention_area_id,
            'location' => 'Updated location',
            'target_amount' => '75000',
            'raised_amount' => '15000',
            'currency' => 'USD',
            'status' => 'in_progress',
            'featured_image' => $project->featured_image,
            'is_featured' => '1',
            'is_published' => '1',
            'translations' => [
                'fr' => [
                    'title' => 'Projet DedeFund mis a jour',
                    'slug' => 'projet-dedefund-mis-a-jour',
                    'summary' => 'Resume mis a jour.',
                    'description' => 'Description mise a jour.',
                ],
                'en' => [
                    'title' => 'Updated DedeFund project',
                    'slug' => 'updated-dedefund-project',
                    'summary' => 'Updated summary.',
                    'description' => 'Updated description.',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.projects.edit', $project));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'location' => 'Updated location',
            'status' => 'in_progress',
        ]);

        $this->assertDatabaseHas('project_translations', [
            'project_id' => $project->id,
            'locale' => 'fr',
            'title' => 'Projet DedeFund mis a jour',
        ]);
    }

    public function test_admin_can_triage_donation_intent(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@dedefund.local')->firstOrFail();
        $donation = DonationIntent::create([
            'donor_name' => 'Ada Donor',
            'email' => 'ada@example.com',
            'donation_method' => 'PayPal',
            'amount' => 250,
            'currency' => 'USD',
            'status' => 'new',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.donations.show', $donation))
            ->assertOk()
            ->assertSee('Ada Donor');

        $this->actingAs($admin)
            ->put(route('admin.donations.update', $donation), ['status' => 'contacted'])
            ->assertRedirect();

        $this->assertDatabaseHas('donation_intents', [
            'id' => $donation->id,
            'status' => 'contacted',
        ]);
    }
}
