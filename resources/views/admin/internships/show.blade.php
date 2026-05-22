<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Internship application</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto grid max-w-5xl gap-6 sm:px-6 lg:grid-cols-[1fr_320px] lg:px-8">
            <section class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-2xl font-black text-gray-900">{{ $internship->full_name }}</h3>
                <dl class="mt-6 grid gap-4 text-sm md:grid-cols-2">
                    <div><dt class="font-bold text-gray-500">Email</dt><dd class="mt-1">{{ $internship->email }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Phone</dt><dd class="mt-1">{{ $internship->phone ?: 'Not provided' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Country</dt><dd class="mt-1">{{ $internship->country ?: 'Not provided' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Domain</dt><dd class="mt-1">{{ $internship->domain ?: 'Not specified' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Type</dt><dd class="mt-1">{{ $internship->internship_type ?: 'Not specified' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Desired start</dt><dd class="mt-1">{{ optional($internship->desired_start_date)->format('M d, Y') ?: 'Not specified' }}</dd></div>
                </dl>
                <div class="mt-6">
                    <div class="font-bold text-gray-500">Motivation</div>
                    <p class="mt-2 whitespace-pre-line text-gray-700">{{ $internship->motivation ?: 'Not provided.' }}</p>
                </div>
                <div class="mt-6">
                    <div class="font-bold text-gray-500">Documents</div>
                    <div class="mt-2 grid gap-2 text-sm">
                        @forelse (\Illuminate\Support\Arr::dot($internship->documents ?? []) as $label => $path)
                            <a class="font-bold text-emerald-700" href="{{ route('admin.files.show', ['path' => $path]) }}">{{ str_replace('_', ' ', $label) }}: {{ basename($path) }}</a>
                        @empty
                            <span class="text-gray-500">No documents uploaded.</span>
                        @endforelse
                    </div>
                </div>
            </section>

            <aside class="h-fit rounded-lg bg-white p-6 shadow-sm">
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-900">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.internships.update', $internship) }}" class="grid gap-4">
                    @csrf
                    @method('PUT')
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Status
                        <select class="rounded-md border-gray-300" name="status">
                            @foreach (['new', 'reviewing', 'accepted', 'rejected', 'contacted'] as $status)
                                <option value="{{ $status }}" @selected($internship->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Internal notes
                        <textarea class="rounded-md border-gray-300" rows="6" name="internal_notes">{{ old('internal_notes', $internship->internal_notes) }}</textarea>
                    </label>
                    <button class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-bold text-white">Save application</button>
                </form>
                <a class="mt-4 inline-flex text-sm font-bold text-gray-600" href="{{ route('admin.internships.index') }}">Back to list</a>
            </aside>
        </div>
    </div>
</x-app-layout>
