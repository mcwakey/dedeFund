<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit post</h2>
            @if ($post->status === 'published' && $post->translation('fr')?->slug)
                <a class="text-sm font-bold text-emerald-700 hover:text-emerald-900" href="{{ route('blog.show', ['locale' => 'fr', 'slug' => $post->translation('fr')->slug]) }}">View public post</a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('status') }}</div>
            @endif

            @include('admin.posts.form', [
                'action' => route('admin.posts.update', $post),
                'method' => 'PUT',
                'submitLabel' => 'Save changes',
            ])

            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                @csrf
                @method('DELETE')
                <button class="rounded-md border border-red-300 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete post</button>
            </form>
        </div>
    </div>
</x-app-layout>
