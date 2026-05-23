<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Create action area</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            @include('admin.areas.form', [
                'action' => route('admin.areas.store'),
                'method' => 'POST',
                'submitLabel' => 'Create action area',
            ])
        </div>
    </div>
</x-app-layout>
