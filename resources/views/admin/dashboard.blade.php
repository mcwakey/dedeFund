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
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold uppercase tracking-wide text-gray-500">{{ str_replace('_', ' ', $label) }}</div>
                        <div class="mt-2 text-3xl font-black text-gray-900">{{ $value }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-gray-900">Latest donation intents</h3>
                    <div class="mt-4 divide-y divide-gray-100">
                        @forelse ($latestDonationIntents as $intent)
                            <div class="py-3 text-sm">
                                <div class="font-semibold">{{ $intent->donor_name }} - {{ $intent->amount }} {{ $intent->currency }}</div>
                                <div class="text-gray-500">{{ $intent->email }}</div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No donation intents yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-gray-900">Latest contact messages</h3>
                    <div class="mt-4 divide-y divide-gray-100">
                        @forelse ($latestMessages as $message)
                            <div class="py-3 text-sm">
                                <div class="font-semibold">{{ $message->full_name }} - {{ $message->subject ?: 'General' }}</div>
                                <div class="text-gray-500">{{ $message->email }}</div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No messages yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
