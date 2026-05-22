<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostTranslation;

class BlogController extends Controller
{
    public function index(string $locale)
    {
        app()->setLocale($locale);

        return view('public.blog.index', [
            'locale' => $locale,
            'posts' => Post::published()
                ->with(['translations', 'category.translations'])
                ->latest('published_at')
                ->paginate(9),
        ]);
    }

    public function show(string $locale, string $slug)
    {
        app()->setLocale($locale);

        $translation = PostTranslation::where('locale', $locale)
            ->where('slug', $slug)
            ->firstOrFail();

        $post = Post::published()
            ->with(['translations', 'category.translations', 'author'])
            ->findOrFail($translation->post_id);

        return view('public.blog.show', compact('locale', 'post'));
    }
}
