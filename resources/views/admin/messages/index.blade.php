<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Contact messages</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3">Sender</th>
                            <th class="px-5 py-3">Subject</th>
                            <th class="px-5 py-3">Context</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($messages as $message)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-gray-900">{{ $message->full_name }}</div>
                                    <div class="text-gray-500">{{ $message->email }}</div>
                                </td>
                                <td class="px-5 py-4">{{ $message->subject ?: 'General message' }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $message->context }}</td>
                                <td class="px-5 py-4"><span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold">{{ $message->status }}</span></td>
                                <td class="px-5 py-4 text-right"><a class="font-bold text-emerald-700" href="{{ route('admin.messages.show', $message) }}">Open</a></td>
                            </tr>
                        @empty
                            <tr><td class="px-5 py-8 text-center text-gray-500" colspan="5">No messages yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $messages->links() }}
        </div>
    </div>
</x-app-layout>
