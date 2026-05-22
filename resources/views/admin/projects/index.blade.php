<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Projects</h2>
            <a href="{{ route('admin.projects.create') }}" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-800">New project</a>
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
                    @foreach (['open', 'funded', 'in_progress', 'completed', 'suspended'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                    @endforeach
                </select>
                <button class="rounded-md border border-gray-300 px-4 py-2 text-sm font-bold hover:bg-gray-50">Filter</button>
            </form>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3">Project</th>
                            <th class="px-5 py-3">Area</th>
                            <th class="px-5 py-3">Funding</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($projects as $project)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900">{{ $project->localized('title', 'fr') }}</div>
                                    <div class="mt-1 text-gray-500">{{ $project->location ?: 'No location' }}</div>
                                </td>
                                <td class="px-5 py-4 text-gray-600">{{ $project->area?->localized('name', 'fr') ?: 'Unassigned' }}</td>
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-gray-900">{{ number_format((float) $project->raised_amount) }} / {{ number_format((float) $project->target_amount) }} {{ $project->currency }}</div>
                                    <div class="mt-2 h-2 w-40 overflow-hidden rounded-full bg-gray-100">
                                        <div class="h-full rounded-full bg-emerald-600" style="width: {{ $project->fundingPercent() }}%"></div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-700">{{ str_replace('_', ' ', $project->status) }}</span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a class="font-bold text-emerald-700 hover:text-emerald-900" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-5 py-8 text-center text-gray-500" colspan="5">No projects found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $projects->links() }}
        </div>
    </div>
</x-app-layout>
