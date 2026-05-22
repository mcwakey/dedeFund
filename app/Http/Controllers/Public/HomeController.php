<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\InterventionArea;
use App\Models\Post;
use App\Models\Project;

class HomeController extends Controller
{
    public function __invoke(string $locale)
    {
        app()->setLocale($locale);

        return view('public.home', [
            'locale' => $locale,
            'areas' => InterventionArea::published()
                ->with('translations')
                ->orderBy('sort_order')
                ->get(),
            'featuredProjects' => Project::published()
                ->featured()
                ->with(['translations', 'area.translations'])
                ->latest()
                ->take(3)
                ->get(),
            'latestPosts' => Post::published()
                ->with(['translations', 'category.translations'])
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
