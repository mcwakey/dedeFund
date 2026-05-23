<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Website control center</h2>
                <p class="mt-1 text-sm text-gray-500">Run the public site, content, donations, and community applications from one place.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a class="rounded-md border border-gray-300 px-4 py-2 text-sm font-bold text-gray-700 hover:bg-gray-50" href="{{ route('home', ['locale' => 'fr']) }}">View site</a>
                <a class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-800" href="{{ route('admin.settings.edit') }}">Website settings</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-5">
                @foreach ($metrics as $label => $value)
                    <div class="rounded-lg bg-white p-5 shadow-sm">
                        <div class="text-xs font-bold uppercase tracking-wide text-gray-500">{{ str_replace('_', ' ', $label) }}</div>
                        <div class="mt-2 text-3xl font-black text-gray-900">{{ $value }}</div>
                    </div>
                @endforeach
            </section>

            <section class="grid gap-5 lg:grid-cols-4">
                @foreach ($controlModules as $module)
                    @php
                        $toneClasses = match ($module['label']) {
                            'Projects' => 'border-emerald-100 bg-emerald-50 text-emerald-800',
                            'Action areas' => 'border-blue-100 bg-blue-50 text-blue-800',
                            'Blog and news' => 'border-amber-100 bg-amber-50 text-amber-800',
                            'Donations' => 'border-lime-100 bg-lime-50 text-lime-800',
                            'Volunteers' => 'border-sky-100 bg-sky-50 text-sky-800',
                            'Internships' => 'border-cyan-100 bg-cyan-50 text-cyan-800',
                            'Messages' => 'border-rose-100 bg-rose-50 text-rose-800',
                            default => 'border-slate-200 bg-slate-50 text-slate-800',
                        };
                    @endphp
                    <div class="rounded-lg bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <span class="rounded-full border px-3 py-1 text-xs font-black {{ $toneClasses }}">{{ $module['count'] }}</span>
                            <a class="text-sm font-bold text-emerald-700 hover:text-emerald-900" href="{{ $module['href'] }}">Manage</a>
                        </div>
                        <h3 class="mt-4 text-lg font-black text-gray-900">{{ $module['label'] }}</h3>
                        <p class="mt-2 min-h-16 text-sm leading-6 text-gray-500">{{ $module['description'] }}</p>
                        <a class="mt-4 inline-flex text-sm font-bold text-gray-700 hover:text-gray-950" href="{{ $module['action_href'] }}">{{ $module['action_label'] }}</a>
                    </div>
                @endforeach
            </section>

            <section class="grid gap-6 lg:grid-cols-[0.8fr_1fr_1fr]">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-gray-900">Needs attention</h3>
                    <div class="mt-4 divide-y divide-gray-100">
                        @foreach ($attentionItems as $item)
                            <a href="{{ $item['href'] }}" class="flex items-center justify-between gap-3 py-3 text-sm hover:bg-gray-50">
                                <span class="font-semibold text-gray-700">{{ $item['label'] }}</span>
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-black text-gray-700">{{ $item['count'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="font-bold text-gray-900">Latest donation intents</h3>
                        <a class="text-sm font-bold text-emerald-700" href="{{ route('admin.donations.index') }}">All</a>
                    </div>
                    <div class="mt-4 divide-y divide-gray-100">
                        @forelse ($latestDonationIntents as $intent)
                            <a href="{{ route('admin.donations.show', $intent) }}" class="block py-3 text-sm hover:bg-gray-50">
                                <div class="font-semibold text-gray-900">{{ $intent->donor_name }} - {{ $intent->amount }} {{ $intent->currency }}</div>
                                <div class="text-gray-500">{{ $intent->email }} / {{ ucfirst($intent->status) }}</div>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500">No donation intents yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="font-bold text-gray-900">Latest messages</h3>
                        <a class="text-sm font-bold text-emerald-700" href="{{ route('admin.messages.index') }}">All</a>
                    </div>
                    <div class="mt-4 divide-y divide-gray-100">
                        @forelse ($latestMessages as $message)
                            <a href="{{ route('admin.messages.show', $message) }}" class="block py-3 text-sm hover:bg-gray-50">
                                <div class="font-semibold text-gray-900">{{ $message->full_name }} - {{ $message->subject ?: 'General' }}</div>
                                <div class="text-gray-500">{{ $message->email }} / {{ ucfirst($message->status) }}</div>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500">No messages yet.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="font-bold text-gray-900">Recent site content</h3>
                    <a class="text-sm font-bold text-emerald-700" href="{{ route('admin.posts.index') }}">Manage posts</a>
                </div>
                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    @forelse ($latestPosts as $post)
                        <a class="rounded-lg border border-gray-200 p-4 hover:bg-gray-50" href="{{ route('admin.posts.edit', $post) }}">
                            <div class="text-xs font-bold uppercase tracking-wide text-gray-500">{{ ucfirst($post->status) }}</div>
                            <div class="mt-2 font-bold text-gray-900">{{ $post->localized('title', 'fr') }}</div>
                            <p class="mt-2 line-clamp-2 text-sm text-gray-500">{{ $post->localized('summary', 'fr', 'No summary yet.') }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500">No posts yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
