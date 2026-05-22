<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Donation intent</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto grid max-w-5xl gap-6 sm:px-6 lg:grid-cols-[1fr_320px] lg:px-8">
            <section class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-2xl font-black text-gray-900">{{ $donation->donor_name }}</h3>
                <dl class="mt-6 grid gap-4 text-sm md:grid-cols-2">
                    <div><dt class="font-bold text-gray-500">Email</dt><dd class="mt-1">{{ $donation->email }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Phone</dt><dd class="mt-1">{{ $donation->phone ?: 'Not provided' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Country</dt><dd class="mt-1">{{ $donation->country ?: 'Not provided' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Method</dt><dd class="mt-1">{{ $donation->donation_method ?: 'Not specified' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Project</dt><dd class="mt-1">{{ $donation->project?->localized('title', 'fr') ?: 'General support' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Amount</dt><dd class="mt-1">{{ $donation->amount ? number_format((float) $donation->amount).' '.$donation->currency : 'Not specified' }}</dd></div>
                </dl>
                <div class="mt-6">
                    <div class="font-bold text-gray-500">Message</div>
                    <p class="mt-2 whitespace-pre-line text-gray-700">{{ $donation->message ?: 'No message.' }}</p>
                </div>
            </section>

            <aside class="h-fit rounded-lg bg-white p-6 shadow-sm">
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-900">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.donations.update', $donation) }}" class="grid gap-4">
                    @csrf
                    @method('PUT')
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Follow-up status
                        <select class="rounded-md border-gray-300" name="status">
                            @foreach (['new', 'contacted', 'confirmed', 'rejected', 'closed'] as $status)
                                <option value="{{ $status }}" @selected($donation->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-bold text-white">Save status</button>
                </form>
                <a class="mt-4 inline-flex text-sm font-bold text-gray-600" href="{{ route('admin.donations.index') }}">Back to list</a>
            </aside>
        </div>
    </div>
</x-app-layout>
