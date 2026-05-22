<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\DonationIntent;
use App\Models\InternshipApplication;
use App\Models\Post;
use App\Models\Project;
use App\Models\VolunteerApplication;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'metrics' => [
                'projects' => Project::count(),
                'published_posts' => Post::published()->count(),
                'donation_intents' => DonationIntent::count(),
                'volunteers' => VolunteerApplication::count(),
                'internships' => InternshipApplication::count(),
                'messages' => ContactMessage::count(),
            ],
            'latestDonationIntents' => DonationIntent::latest()->take(5)->get(),
            'latestMessages' => ContactMessage::latest()->take(5)->get(),
        ]);
    }
}
