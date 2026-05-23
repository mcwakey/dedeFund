<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostManagementController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->with(['translations', 'category.translations', 'author'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');

                $query->whereHas('translations', fn ($translationQuery) => $translationQuery
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%"));
            })
            ->latest('published_at')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'post' => new Post([
                'status' => 'draft',
                'published_at' => now(),
            ]),
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $post = Post::create($this->postAttributes($validated, $request));
        $this->syncTranslations($post, $validated['translations']);

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('status', 'Post created.');
    }

    public function edit(Post $post): View
    {
        $post->load('translations');

        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $this->categories(),
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $post->update($this->postAttributes($validated, $request, $post));
        $this->syncTranslations($post, $validated['translations']);

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('status', 'Post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'featured_image' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', 'string', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'translations.fr.title' => ['required', 'string', 'max:255'],
            'translations.fr.slug' => ['nullable', 'string', 'max:255'],
            'translations.fr.summary' => ['nullable', 'string', 'max:1000'],
            'translations.fr.content' => ['nullable', 'string'],
            'translations.en.title' => ['nullable', 'string', 'max:255'],
            'translations.en.slug' => ['nullable', 'string', 'max:255'],
            'translations.en.summary' => ['nullable', 'string', 'max:1000'],
            'translations.en.content' => ['nullable', 'string'],
        ]);
    }

    private function postAttributes(array $validated, Request $request, ?Post $post = null): array
    {
        $publishedAt = null;

        if ($validated['status'] === 'published') {
            $publishedAt = $validated['published_at'] ?? $post?->published_at ?? now();
        }

        return Arr::only($validated, ['category_id', 'featured_image', 'status']) + [
            'author_id' => $post?->author_id ?? $request->user()->id,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $publishedAt,
        ];
    }

    private function syncTranslations(Post $post, array $translations): void
    {
        foreach (['fr', 'en'] as $locale) {
            $data = $translations[$locale] ?? [];

            if ($locale === 'en' && blank($data['title'] ?? null)) {
                continue;
            }

            $title = $data['title'];

            $post->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $title,
                    'slug' => filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($title),
                    'summary' => $data['summary'] ?? null,
                    'content' => $data['content'] ?? null,
                    'meta_title' => $title.' - DedeFund',
                    'meta_description' => $data['summary'] ?? null,
                ],
            );
        }
    }

    private function categories()
    {
        return Category::with('translations')
            ->where('type', 'post')
            ->orderBy('id')
            ->get();
    }
}
