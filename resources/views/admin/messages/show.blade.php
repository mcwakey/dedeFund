<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Contact message</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto grid max-w-5xl gap-6 sm:px-6 lg:grid-cols-[1fr_320px] lg:px-8">
            <section class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-2xl font-black text-gray-900">{{ $message->subject ?: 'General message' }}</h3>
                <dl class="mt-6 grid gap-4 text-sm md:grid-cols-2">
                    <div><dt class="font-bold text-gray-500">Name</dt><dd class="mt-1">{{ $message->full_name }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Email</dt><dd class="mt-1">{{ $message->email }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Phone</dt><dd class="mt-1">{{ $message->phone ?: 'Not provided' }}</dd></div>
                    <div><dt class="font-bold text-gray-500">Context</dt><dd class="mt-1">{{ $message->context }}</dd></div>
                </dl>
                <div class="mt-6">
                    <div class="font-bold text-gray-500">Message</div>
                    <p class="mt-2 whitespace-pre-line text-gray-700">{{ $message->message }}</p>
                </div>
            </section>

            <aside class="h-fit rounded-lg bg-white p-6 shadow-sm">
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-900">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="grid gap-4">
                    @csrf
                    @method('PUT')
                    <label class="grid gap-2 text-sm font-semibold text-gray-700">Status
                        <select class="rounded-md border-gray-300" name="status">
                            @foreach (['new', 'read', 'archived'] as $status)
                                <option value="{{ $status }}" @selected($message->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-bold text-white">Save status</button>
                </form>
                <a class="mt-4 inline-flex text-sm font-bold text-gray-600" href="{{ route('admin.messages.index') }}">Back to list</a>
            </aside>
        </div>
    </div>
</x-app-layout>
