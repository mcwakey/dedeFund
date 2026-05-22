<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTranslation;

class ProjectController extends Controller
{
    public function index(string $locale)
    {
        app()->setLocale($locale);

        return view('public.projects.index', [
            'locale' => $locale,
            'projects' => Project::published()
                ->with(['translations', 'area.translations'])
                ->latest()
                ->paginate(9),
        ]);
    }

    public function show(string $locale, string $slug)
    {
        app()->setLocale($locale);

        $translation = ProjectTranslation::where('locale', $locale)
            ->where('slug', $slug)
            ->firstOrFail();

        $project = Project::published()
            ->with(['translations', 'area.translations'])
            ->findOrFail($translation->project_id);

        return view('public.projects.show', compact('locale', 'project'));
    }
}
