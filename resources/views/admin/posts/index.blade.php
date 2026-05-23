<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Blog and news</h2>
                <p class="mt-1 text-sm text-gray-500">Publish updates, announcements, and campaign stories.</p>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-800">New post</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('status') }}</div>
            @endif

            <form class="grid gap-3 rounded-lg bg-white p-4 shadow-sm md:grid-cols-[1fr_180px_auto]" method="GET">
                <input class="rounded-md border-gray-300" name="search" value="{{ request('search') }}" placeholder="Search title or summary">
                <select class="rounded-md border-gray-300" name="status">
                    <option value="">All statuses</option>
                    @foreach (['draft', 'published'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="rounded-md border border-gray-300 px-4 py-2 text-sm font-bold hover:bg-gray-50">Filter</button>
            </form>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3">Post</th>
                            <th class="px-5 py-3">Category</th>
                            <th class="px-5 py-3">Published</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($posts as $post)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900">{{ $post->localized('title', 'fr') }}</div>
                                    <div class="mt-1 max-w-xl text-gray-500">{{ $post->localized('summary', 'fr', 'No summary yet.') }}</div>
                                    @if ($post->is_featured)
                                        <div class="mt-2 text-xs font-bold uppercase tracking-wide text-amber-600">Featured</div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-gray-600">{{ $post->category?->localized('name', 'fr') ?: 'Uncategorized' }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $post->published_at?->format('M j, Y') ?: 'Not scheduled' }}</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a class="font-bold text-emerald-700 hover:text-emerald-900" href="{{ route('admin.posts.edit', $post) }}">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-5 py-8 text-center text-gray-500" colspan="5">No posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
