@php
    $field = fn (string $locale, string $name) => old("translations.$locale.$name", $project->translation($locale)?->{$name});
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
        <strong>Please check the form.</strong>
        <ul class="mt-2 list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $action }}" class="space-y-6 rounded-lg bg-white p-6 shadow-sm">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <section class="grid gap-5 md:grid-cols-2">
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Intervention area
            <select class="rounded-md border-gray-300" name="intervention_area_id">
                <option value="">Unassigned</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @selected((string) old('intervention_area_id', $project->intervention_area_id) === (string) $area->id)>{{ $area->localized('name', 'fr') }}</option>
                @endforeach
            </select>
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Location
            <input class="rounded-md border-gray-300" name="location" value="{{ old('location', $project->location) }}">
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Target amount
            <input class="rounded-md border-gray-300" type="number" min="0" step="0.01" name="target_amount" value="{{ old('target_amount', $project->target_amount ?? 0) }}" required>
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Raised amount
            <input class="rounded-md border-gray-300" type="number" min="0" step="0.01" name="raised_amount" value="{{ old('raised_amount', $project->raised_amount ?? 0) }}" required>
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Currency
            <input class="rounded-md border-gray-300 uppercase" maxlength="3" name="currency" value="{{ old('currency', $project->currency ?? 'USD') }}" required>
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Status
            <select class="rounded-md border-gray-300" name="status" required>
                @foreach (['open', 'funded', 'in_progress', 'completed', 'suspended'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $project->status ?? 'open') === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                @endforeach
            </select>
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700 md:col-span-2">Featured image URL
            <input class="rounded-md border-gray-300" type="url" name="featured_image" value="{{ old('featured_image', $project->featured_image) }}">
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Start date
            <input class="rounded-md border-gray-300" type="date" name="start_date" value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}">
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">End date
            <input class="rounded-md border-gray-300" type="date" name="end_date" value="{{ old('end_date', optional($project->end_date)->format('Y-m-d')) }}">
        </label>
        <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
            <input class="rounded border-gray-300 text-emerald-700" type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured))>
            Featured on homepage
        </label>
        <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
            <input class="rounded border-gray-300 text-emerald-700" type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published ?? true))>
            Published
        </label>
    </section>

    @foreach (['fr' => 'French', 'en' => 'English'] as $locale => $label)
        <section class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-black text-gray-900">{{ $label }} content</h3>
            <div class="mt-4 grid gap-5">
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Title
                        <input class="rounded-md border-gray-300" name="translations[{{ $locale }}][title]" value="{{ $field($locale, 'title') }}" @required($locale === 'fr')>
                    </label>
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Slug
                        <input class="rounded-md border-gray-300" name="translations[{{ $locale }}][slug]" value="{{ $field($locale, 'slug') }}">
                    </label>
                </div>
                <label class="grid gap-2 text-sm font-semibold text-gray-700">Summary
                    <textarea class="rounded-md border-gray-300" rows="3" name="translations[{{ $locale }}][summary]">{{ $field($locale, 'summary') }}</textarea>
                </label>
                <label class="grid gap-2 text-sm font-semibold text-gray-700">Description
                    <textarea class="rounded-md border-gray-300" rows="5" name="translations[{{ $locale }}][description]">{{ $field($locale, 'description') }}</textarea>
                </label>
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Beneficiaries
                        <textarea class="rounded-md border-gray-300" rows="3" name="translations[{{ $locale }}][beneficiaries]">{{ $field($locale, 'beneficiaries') }}</textarea>
                    </label>
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">General objective
                        <textarea class="rounded-md border-gray-300" rows="3" name="translations[{{ $locale }}][general_objective]">{{ $field($locale, 'general_objective') }}</textarea>
                    </label>
                </div>
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Specific objectives
                        <textarea class="rounded-md border-gray-300" rows="4" name="translations[{{ $locale }}][specific_objectives]">{{ $field($locale, 'specific_objectives') }}</textarea>
                    </label>
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Expected impact
                        <textarea class="rounded-md border-gray-300" rows="4" name="translations[{{ $locale }}][expected_impact]">{{ $field($locale, 'expected_impact') }}</textarea>
                    </label>
                </div>
            </div>
        </section>
    @endforeach

    <div class="flex items-center gap-3 border-t border-gray-200 pt-6">
        <button class="rounded-md bg-emerald-700 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-800">{{ $submitLabel }}</button>
        <a class="text-sm font-bold text-gray-600 hover:text-gray-900" href="{{ route('admin.projects.index') }}">Cancel</a>
    </div>
</form>
