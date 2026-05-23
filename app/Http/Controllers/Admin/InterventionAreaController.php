<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterventionArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InterventionAreaController extends Controller
{
    public function index(Request $request): View
    {
        $areas = InterventionArea::query()
            ->withCount('projects')
            ->with('translations')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');

                $query->whereHas('translations', fn ($translationQuery) => $translationQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%"));
            })
            ->orderBy('sort_order')
            ->paginate(12)
            ->withQueryString();

        return view('admin.areas.index', compact('areas'));
    }

    public function create(): View
    {
        return view('admin.areas.create', [
            'area' => new InterventionArea([
                'color' => 'emerald',
                'sort_order' => InterventionArea::max('sort_order') + 1,
                'is_published' => true,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $area = InterventionArea::create($this->areaAttributes($validated, $request));
        $this->syncTranslations($area, $validated['translations']);

        return redirect()
            ->route('admin.areas.edit', $area)
            ->with('status', 'Action area created.');
    }

    public function edit(InterventionArea $area): View
    {
        $area->load('translations');

        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, InterventionArea $area): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $area->update($this->areaAttributes($validated, $request));
        $this->syncTranslations($area, $validated['translations']);

        return redirect()
            ->route('admin.areas.edit', $area)
            ->with('status', 'Action area updated.');
    }

    public function destroy(InterventionArea $area): RedirectResponse
    {
        if ($area->projects()->exists()) {
            return back()->withErrors('Move or delete the related projects before deleting this action area.');
        }

        $area->delete();

        return redirect()
            ->route('admin.areas.index')
            ->with('status', 'Action area deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'icon' => ['nullable', 'string', 'max:80'],
            'color' => ['required', 'string', 'max:40'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'translations.fr.name' => ['required', 'string', 'max:255'],
            'translations.fr.slug' => ['nullable', 'string', 'max:255'],
            'translations.fr.summary' => ['nullable', 'string', 'max:1000'],
            'translations.fr.body' => ['nullable', 'string'],
            'translations.en.name' => ['nullable', 'string', 'max:255'],
            'translations.en.slug' => ['nullable', 'string', 'max:255'],
            'translations.en.summary' => ['nullable', 'string', 'max:1000'],
            'translations.en.body' => ['nullable', 'string'],
        ]);
    }

    private function areaAttributes(array $validated, Request $request): array
    {
        return Arr::only($validated, ['icon', 'color', 'sort_order']) + [
            'is_published' => $request->boolean('is_published'),
        ];
    }

    private function syncTranslations(InterventionArea $area, array $translations): void
    {
        foreach (['fr', 'en'] as $locale) {
            $data = $translations[$locale] ?? [];

            if ($locale === 'en' && blank($data['name'] ?? null)) {
                continue;
            }

            $name = $data['name'];

            $area->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name' => $name,
                    'slug' => filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($name),
                    'summary' => $data['summary'] ?? null,
                    'body' => $data['body'] ?? null,
                ],
            );
        }
    }
}
