<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            DedeFund Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($metrics as $label => $value)
                    <a href="{{ match ($label) {
                        'projects' => route('admin.projects.index'),
                        'donation_intents' => route('admin.donations.index'),
                        'volunteers' => route('admin.volunteers.index'),
                        'internships' => route('admin.internships.index'),
                        'messages' => route('admin.messages.index'),
                        default => route('admin.dashboard'),
                    } }}" class="rounded-lg bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="text-sm font-semibold uppercase tracking-wide text-gray-500">{{ str_replace('_', ' ', $label) }}</div>
                        <div class="mt-2 text-3xl font-black text-gray-900">{{ $value }}</div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-gray-900">Latest donation intents</h3>
                    <div class="mt-4 divide-y divide-gray-100">
                        @forelse ($latestDonationIntents as $intent)
                            <a href="{{ route('admin.donations.show', $intent) }}" class="block py-3 text-sm hover:bg-gray-50">
                                <div class="font-semibold">{{ $intent->donor_name }} - {{ $intent->amount }} {{ $intent->currency }}</div>
                                <div class="text-gray-500">{{ $intent->email }}</div>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500">No donation intents yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-gray-900">Latest contact messages</h3>
                    <div class="mt-4 divide-y divide-gray-100">
                        @forelse ($latestMessages as $message)
                            <a href="{{ route('admin.messages.show', $message) }}" class="block py-3 text-sm hover:bg-gray-50">
                                <div class="font-semibold">{{ $message->full_name }} - {{ $message->subject ?: 'General' }}</div>
                                <div class="text-gray-500">{{ $message->email }}</div>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500">No messages yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
