<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\DonationIntent;
use App\Models\InternshipApplication;
use App\Models\InterventionArea;
use App\Models\Post;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\VolunteerApplication;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $newDonations = DonationIntent::where('status', 'new')->count();
        $newMessages = ContactMessage::where('status', 'new')->count();
        $newVolunteers = VolunteerApplication::where('status', 'new')->count();
        $newInternships = InternshipApplication::where('status', 'new')->count();

        return view('admin.dashboard', [
            'metrics' => [
                'projects' => Project::count(),
                'action_areas' => InterventionArea::count(),
                'published_posts' => Post::published()->count(),
                'draft_posts' => Post::where('status', 'draft')->count(),
                'new_inbox_items' => $newDonations + $newMessages + $newVolunteers + $newInternships,
            ],
            'controlModules' => [
                [
                    'label' => 'Projects',
                    'description' => 'Campaign pages, funding goals, public visibility, and project translations.',
                    'count' => Project::count(),
                    'href' => route('admin.projects.index'),
                    'action_href' => route('admin.projects.create'),
                    'action_label' => 'New project',
                    'classes' => 'border-emerald-100 bg-emerald-50 text-emerald-800',
                ],
                [
                    'label' => 'Action areas',
                    'description' => 'The public Actions page and the thematic groups used by projects.',
                    'count' => InterventionArea::count(),
                    'href' => route('admin.areas.index'),
                    'action_href' => route('admin.areas.create'),
                    'action_label' => 'New area',
                    'classes' => 'border-blue-100 bg-blue-50 text-blue-800',
                ],
                [
                    'label' => 'Blog and news',
                    'description' => 'Stories, updates, announcements, and bilingual post content.',
                    'count' => Post::count(),
                    'href' => route('admin.posts.index'),
                    'action_href' => route('admin.posts.create'),
                    'action_label' => 'New post',
                    'classes' => 'border-amber-100 bg-amber-50 text-amber-800',
                ],
                [
                    'label' => 'Donations',
                    'description' => 'Donation intents, donor follow-up, methods, and contribution notes.',
                    'count' => DonationIntent::count(),
                    'href' => route('admin.donations.index'),
                    'action_href' => route('admin.settings.edit'),
                    'action_label' => 'Donation settings',
                    'classes' => 'border-lime-100 bg-lime-50 text-lime-800',
                ],
                [
                    'label' => 'Volunteers',
                    'description' => 'Volunteer applications, skills, availability, and internal triage.',
                    'count' => VolunteerApplication::count(),
                    'href' => route('admin.volunteers.index'),
                    'action_href' => route('volunteer', ['locale' => 'fr']),
                    'action_label' => 'Public form',
                    'classes' => 'border-sky-100 bg-sky-50 text-sky-800',
                ],
                [
                    'label' => 'Internships',
                    'description' => 'Internship requests, preferred domains, documents, and decisions.',
                    'count' => InternshipApplication::count(),
                    'href' => route('admin.internships.index'),
                    'action_href' => route('internships', ['locale' => 'fr']),
                    'action_label' => 'Public form',
                    'classes' => 'border-purple-100 bg-purple-50 text-purple-800',
                ],
                [
                    'label' => 'Messages',
                    'description' => 'Contact requests from donors, partners, volunteers, and visitors.',
                    'count' => ContactMessage::count(),
                    'href' => route('admin.messages.index'),
                    'action_href' => route('contact', ['locale' => 'fr']),
                    'action_label' => 'Public contact',
                    'classes' => 'border-rose-100 bg-rose-50 text-rose-800',
                ],
                [
                    'label' => 'Website settings',
                    'description' => 'Contact information, WhatsApp, PayPal, bank details, and defaults.',
                    'count' => SiteSetting::count(),
                    'href' => route('admin.settings.edit'),
                    'action_href' => route('home', ['locale' => 'fr']),
                    'action_label' => 'View site',
                    'classes' => 'border-slate-200 bg-slate-50 text-slate-800',
                ],
            ],
            'attentionItems' => [
                ['label' => 'New donation intents', 'count' => $newDonations, 'href' => route('admin.donations.index', ['status' => 'new'])],
                ['label' => 'Unread contact messages', 'count' => $newMessages, 'href' => route('admin.messages.index', ['status' => 'new'])],
                ['label' => 'New volunteer applications', 'count' => $newVolunteers, 'href' => route('admin.volunteers.index', ['status' => 'new'])],
                ['label' => 'New internship applications', 'count' => $newInternships, 'href' => route('admin.internships.index', ['status' => 'new'])],
                ['label' => 'Draft posts', 'count' => Post::where('status', 'draft')->count(), 'href' => route('admin.posts.index', ['status' => 'draft'])],
                ['label' => 'Hidden projects', 'count' => Project::where('is_published', false)->count(), 'href' => route('admin.projects.index')],
            ],
            'latestDonationIntents' => DonationIntent::latest()->take(5)->get(),
            'latestMessages' => ContactMessage::latest()->take(5)->get(),
            'latestPosts' => Post::with('translations')->latest()->take(5)->get(),
        ]);
    }
}
