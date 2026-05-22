<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Volunteer applications</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <form class="grid gap-3 rounded-lg bg-white p-4 shadow-sm md:grid-cols-[180px_1fr_auto]" method="GET">
                <select class="rounded-md border-gray-300" name="status">
                    <option value="">All statuses</option>
                    @foreach (['new', 'reviewing', 'accepted', 'rejected', 'contacted'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <input class="rounded-md border-gray-300" name="country" value="{{ request('country') }}" placeholder="Country">
                <button class="rounded-md border border-gray-300 px-4 py-2 text-sm font-bold hover:bg-gray-50">Filter</button>
            </form>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3">Applicant</th>
                            <th class="px-5 py-3">Location</th>
                            <th class="px-5 py-3">Contribution</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($volunteers as $volunteer)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900">{{ $volunteer->full_name }}</div>
                                    <div class="text-gray-500">{{ $volunteer->email }}</div>
                                </td>
                                <td class="px-5 py-4 text-gray-600">{{ collect([$volunteer->city, $volunteer->country])->filter()->join(', ') ?: 'Not provided' }}</td>
                                <td class="px-5 py-4">{{ $volunteer->contribution_type ?: 'Not specified' }}</td>
                                <td class="px-5 py-4"><span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold">{{ $volunteer->status }}</span></td>
                                <td class="px-5 py-4 text-right"><a class="font-bold text-emerald-700" href="{{ route('admin.volunteers.show', $volunteer) }}">Open</a></td>
                            </tr>
                        @empty
                            <tr><td class="px-5 py-8 text-center text-gray-500" colspan="5">No volunteer applications yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $volunteers->links() }}
        </div>
    </div>
</x-app-layout>
