@php
    $field = fn (string $locale, string $name) => old("translations.$locale.$name", $post->translation($locale)?->{$name});
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
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Category
            <select class="rounded-md border-gray-300" name="category_id">
                <option value="">Uncategorized</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $post->category_id) === (string) $category->id)>{{ $category->localized('name', 'fr') }}</option>
                @endforeach
            </select>
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Status
            <select class="rounded-md border-gray-300" name="status" required>
                @foreach (['draft', 'published'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $post->status ?? 'draft') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700 md:col-span-2">Featured image URL
            <input class="rounded-md border-gray-300" type="url" name="featured_image" value="{{ old('featured_image', $post->featured_image) }}">
        </label>
        <label class="grid gap-2 text-sm font-semibold text-gray-700">Publish date
            <input class="rounded-md border-gray-300" type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
        </label>
        <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
            <input class="rounded border-gray-300 text-emerald-700" type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $post->is_featured))>
            Featured story
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
                <label class="grid gap-2 text-sm font-semibold text-gray-700">Content
                    <textarea class="rounded-md border-gray-300" rows="9" name="translations[{{ $locale }}][content]">{{ $field($locale, 'content') }}</textarea>
                </label>
            </div>
        </section>
    @endforeach

    <div class="flex items-center gap-3 border-t border-gray-200 pt-6">
        <button class="rounded-md bg-emerald-700 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-800">{{ $submitLabel }}</button>
        <a class="text-sm font-bold text-gray-600 hover:text-gray-900" href="{{ route('admin.posts.index') }}">Cancel</a>
    </div>
</form>
