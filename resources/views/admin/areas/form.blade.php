@php
    $field = fn (string $locale, string $name) => old("translations.$locale.$name", $area->translation($locale)?->{$name});
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

    <section class="grid gap-5 md:grid-cols-3">
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Icon label
            <input class="rounded-md border-gray-300" name="icon" value="{{ old('icon', $area->icon) }}" placeholder="Education">
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Color token
            <input class="rounded-md border-gray-300" name="color" value="{{ old('color', $area->color ?? 'emerald') }}" required>
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Sort order
            <input class="rounded-md border-gray-300" type="number" min="0" name="sort_order" value="{{ old('sort_order', $area->sort_order ?? 0) }}" required>
        </label>
        <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700 md:col-span-3">
            <input class="rounded border-gray-300 text-emerald-700" type="checkbox" name="is_published" value="1" @checked(old('is_published', $area->is_published ?? true))>
            Published on the public site
        </label>
    </section>

    @foreach (['fr' => 'French', 'en' => 'English'] as $locale => $label)
        <section class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-black text-gray-900">{{ $label }} content</h3>
            <div class="mt-4 grid gap-5">
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Name
                        <input class="rounded-md border-gray-300" name="translations[{{ $locale }}][name]" value="{{ $field($locale, 'name') }}" @required($locale === 'fr')>
                    </label>
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Slug
                        <input class="rounded-md border-gray-300" name="translations[{{ $locale }}][slug]" value="{{ $field($locale, 'slug') }}">
                    </label>
                </div>
                <label class="grid gap-2 text-sm font-semibold text-gray-700">Summary
                    <textarea class="rounded-md border-gray-300" rows="3" name="translations[{{ $locale }}][summary]">{{ $field($locale, 'summary') }}</textarea>
                </label>
                <label class="grid gap-2 text-sm font-semibold text-gray-700">Body
                    <textarea class="rounded-md border-gray-300" rows="6" name="translations[{{ $locale }}][body]">{{ $field($locale, 'body') }}</textarea>
                </label>
            </div>
        </section>
    @endforeach

    <div class="flex items-center gap-3 border-t border-gray-200 pt-6">
        <button class="rounded-md bg-emerald-700 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-800">{{ $submitLabel }}</button>
        <a class="text-sm font-bold text-gray-600 hover:text-gray-900" href="{{ route('admin.areas.index') }}">Cancel</a>
    </div>
</form>
