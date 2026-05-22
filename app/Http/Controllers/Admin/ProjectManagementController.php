<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterventionArea;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectManagementController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::query()
            ->with(['translations', 'area.translations'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');

                $query->whereHas('translations', fn ($translationQuery) => $translationQuery
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create', [
            'project' => new Project([
                'currency' => 'USD',
                'status' => 'open',
                'is_published' => true,
            ]),
            'areas' => $this->areas(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $project = Project::create($this->projectAttributes($validated, $request));
        $this->syncTranslations($project, $validated['translations']);

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('status', 'Project created.');
    }

    public function edit(Project $project): View
    {
        $project->load('translations');

        return view('admin.projects.edit', [
            'project' => $project,
            'areas' => $this->areas(),
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $project->update($this->projectAttributes($validated, $request));
        $this->syncTranslations($project, $validated['translations']);

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Project deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'intervention_area_id' => ['nullable', 'integer', 'exists:intervention_areas,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'target_amount' => ['required', 'numeric', 'min:0'],
            'raised_amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'status' => ['required', 'string', 'in:open,funded,in_progress,completed,suspended'],
            'featured_image' => ['nullable', 'url', 'max:2048'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'translations.fr.title' => ['required', 'string', 'max:255'],
            'translations.fr.slug' => ['nullable', 'string', 'max:255'],
            'translations.fr.summary' => ['nullable', 'string', 'max:1000'],
            'translations.fr.description' => ['nullable', 'string'],
            'translations.fr.beneficiaries' => ['nullable', 'string', 'max:1000'],
            'translations.fr.general_objective' => ['nullable', 'string', 'max:1000'],
            'translations.fr.specific_objectives' => ['nullable', 'string'],
            'translations.fr.expected_impact' => ['nullable', 'string'],
            'translations.en.title' => ['nullable', 'string', 'max:255'],
            'translations.en.slug' => ['nullable', 'string', 'max:255'],
            'translations.en.summary' => ['nullable', 'string', 'max:1000'],
            'translations.en.description' => ['nullable', 'string'],
            'translations.en.beneficiaries' => ['nullable', 'string', 'max:1000'],
            'translations.en.general_objective' => ['nullable', 'string', 'max:1000'],
            'translations.en.specific_objectives' => ['nullable', 'string'],
            'translations.en.expected_impact' => ['nullable', 'string'],
        ]);
    }

    private function projectAttributes(array $validated, Request $request): array
    {
        return Arr::only($validated, [
            'intervention_area_id',
            'location',
            'target_amount',
            'raised_amount',
            'currency',
            'status',
            'featured_image',
            'start_date',
            'end_date',
        ]) + [
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
            'created_by' => $request->user()->id,
        ];
    }

    private function syncTranslations(Project $project, array $translations): void
    {
        foreach (['fr', 'en'] as $locale) {
            $data = $translations[$locale] ?? [];

            if ($locale === 'en' && blank($data['title'] ?? null)) {
                continue;
            }

            $title = $data['title'];

            $project->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $title,
                    'slug' => filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($title),
                    'summary' => $data['summary'] ?? null,
                    'description' => $data['description'] ?? null,
                    'beneficiaries' => $data['beneficiaries'] ?? null,
                    'general_objective' => $data['general_objective'] ?? null,
                    'specific_objectives' => $data['specific_objectives'] ?? null,
                    'expected_impact' => $data['expected_impact'] ?? null,
                    'meta_title' => $title.' - DedeFund',
                    'meta_description' => $data['summary'] ?? null,
                ],
            );
        }
    }

    private function areas()
    {
        return InterventionArea::with('translations')->orderBy('sort_order')->get();
    }
}
