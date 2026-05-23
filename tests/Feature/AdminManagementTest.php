<?php

namespace Tests\Feature;

use App\Models\DonationIntent;
use App\Models\InterventionArea;
use App\Models\Post;
use App\Models\Project;
use App\Models\SiteSetting;
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

    public function test_admin_can_manage_action_areas(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@dedefund.local')->firstOrFail();
        $area = InterventionArea::with('translations')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.areas.index'))
            ->assertOk()
            ->assertSee('Action areas')
            ->assertSee('Promotion de la femme');

        $response = $this->actingAs($admin)->put(route('admin.areas.update', $area), [
            'icon' => 'Community',
            'color' => 'emerald',
            'sort_order' => 7,
            'is_published' => '1',
            'translations' => [
                'fr' => [
                    'name' => 'Solidarite communautaire',
                    'slug' => 'solidarite-communautaire',
                    'summary' => 'Actions locales mises a jour.',
                    'body' => 'Description mise a jour.',
                ],
                'en' => [
                    'name' => 'Community solidarity',
                    'slug' => 'community-solidarity',
                    'summary' => 'Updated local actions.',
                    'body' => 'Updated description.',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.areas.edit', $area));

        $this->assertDatabaseHas('intervention_areas', [
            'id' => $area->id,
            'icon' => 'Community',
            'sort_order' => 7,
        ]);

        $this->assertDatabaseHas('intervention_area_translations', [
            'intervention_area_id' => $area->id,
            'locale' => 'fr',
            'name' => 'Solidarite communautaire',
        ]);
    }

    public function test_admin_can_update_blog_posts(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@dedefund.local')->firstOrFail();
        $post = Post::with('translations')->firstOrFail();

        $response = $this->actingAs($admin)->put(route('admin.posts.update', $post), [
            'category_id' => $post->category_id,
            'featured_image' => $post->featured_image,
            'status' => 'published',
            'is_featured' => '1',
            'published_at' => now()->format('Y-m-d H:i:s'),
            'translations' => [
                'fr' => [
                    'title' => 'Actualite admin mise a jour',
                    'slug' => 'actualite-admin-mise-a-jour',
                    'summary' => 'Resume actualise depuis le tableau de bord.',
                    'content' => 'Contenu actualise.',
                ],
                'en' => [
                    'title' => 'Updated admin news',
                    'slug' => 'updated-admin-news',
                    'summary' => 'Updated summary from the dashboard.',
                    'content' => 'Updated content.',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.posts.edit', $post));

        $this->assertDatabaseHas('post_translations', [
            'post_id' => $post->id,
            'locale' => 'fr',
            'title' => 'Actualite admin mise a jour',
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

    public function test_admin_can_update_public_site_settings(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@dedefund.local')->firstOrFail();

        $response = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'organization_name' => 'DedeFund',
            'default_meta_description' => 'DedeFund updated public description.',
            'address' => '123 Admin Avenue, Lome',
            'phone' => '+228 90 00 00 00',
            'contact_emails' => "hello@dedefund.org\npartners@dedefund.org",
            'whatsapp_number' => '+22890000000',
            'paypal_url' => 'https://www.paypal.com/donate/example',
            'bank_details' => "DedeFund Bank\nAccount 123",
            'show_bank_details' => '1',
        ]);

        $response->assertRedirect();

        $this->assertSame('123 Admin Avenue, Lome', SiteSetting::getValue('address'));
        $this->assertSame(['hello@dedefund.org', 'partners@dedefund.org'], SiteSetting::getValue('contact_emails'));

        $this->get(route('contact', ['locale' => 'fr']))
            ->assertOk()
            ->assertSee('123 Admin Avenue, Lome')
            ->assertSee('hello@dedefund.org');
    }
}
