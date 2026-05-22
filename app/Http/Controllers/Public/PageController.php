<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\InterventionArea;
use App\Models\Project;

class PageController extends Controller
{
    public function about(string $locale)
    {
        app()->setLocale($locale);

        return view('public.about', compact('locale'));
    }

    public function actions(string $locale)
    {
        app()->setLocale($locale);

        return view('public.actions', [
            'locale' => $locale,
            'areas' => InterventionArea::published()->with('translations')->orderBy('sort_order')->get(),
        ]);
    }

    public function donate(string $locale)
    {
        app()->setLocale($locale);

        return view('public.donate', [
            'locale' => $locale,
            'projects' => Project::published()->with('translations')->latest()->get(),
        ]);
    }

    public function volunteer(string $locale)
    {
        app()->setLocale($locale);

        return view('public.volunteer', compact('locale'));
    }

    public function internships(string $locale)
    {
        app()->setLocale($locale);

        return view('public.internships', compact('locale'));
    }

    public function contact(string $locale)
    {
        app()->setLocale($locale);

        return view('public.contact', compact('locale'));
    }

    public function privacy(string $locale)
    {
        app()->setLocale($locale);

        return view('public.static', [
            'locale' => $locale,
            'title' => $locale === 'fr' ? 'Politique de confidentialite' : 'Privacy Policy',
            'body' => $locale === 'fr'
                ? 'Cette page sera completee avec les pratiques de confidentialite de DedeFund avant la mise en production.'
                : 'This page will be completed with DedeFund privacy practices before launch.',
        ]);
    }

    public function terms(string $locale)
    {
        app()->setLocale($locale);

        return view('public.static', [
            'locale' => $locale,
            'title' => $locale === 'fr' ? 'Conditions d utilisation' : 'Terms of Use',
            'body' => $locale === 'fr'
                ? 'Cette page sera completee avec les conditions d utilisation avant la mise en production.'
                : 'This page will be completed with the terms of use before launch.',
        ]);
    }
}
