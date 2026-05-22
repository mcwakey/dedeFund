<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Create project</h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            @include('admin.projects.form', [
                'action' => route('admin.projects.store'),
                'method' => 'POST',
                'submitLabel' => 'Create project',
            ])
        </div>
    </div>
</x-app-layout>
