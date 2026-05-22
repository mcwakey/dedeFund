<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Donation intents</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <form class="flex flex-wrap gap-3 rounded-lg bg-white p-4 shadow-sm" method="GET">
                <select class="rounded-md border-gray-300" name="status">
                    <option value="">All statuses</option>
                    @foreach (['new', 'contacted', 'confirmed', 'rejected', 'closed'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="rounded-md border border-gray-300 px-4 py-2 text-sm font-bold hover:bg-gray-50">Filter</button>
            </form>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3">Donor</th>
                            <th class="px-5 py-3">Project</th>
                            <th class="px-5 py-3">Amount</th>
                            <th class="px-5 py-3">Method</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($donations as $donation)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900">{{ $donation->donor_name }}</div>
                                    <div class="text-gray-500">{{ $donation->email }}</div>
                                </td>
                                <td class="px-5 py-4 text-gray-600">{{ $donation->project?->localized('title', 'fr') ?: 'General support' }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $donation->amount ? number_format((float) $donation->amount).' '.$donation->currency : 'Not specified' }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $donation->donation_method ?: 'Not specified' }}</td>
                                <td class="px-5 py-4"><span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold">{{ $donation->status }}</span></td>
                                <td class="px-5 py-4 text-right"><a class="font-bold text-emerald-700" href="{{ route('admin.donations.show', $donation) }}">Open</a></td>
                            </tr>
                        @empty
                            <tr><td class="px-5 py-8 text-center text-gray-500" colspan="6">No donation intents yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $donations->links() }}
        </div>
    </div>
</x-app-layout>
