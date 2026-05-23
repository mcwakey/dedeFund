<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Website settings</h2>
                <p class="mt-1 text-sm text-gray-500">Manage contact details, donation links, and public site defaults.</p>
            </div>
            <a class="text-sm font-bold text-emerald-700 hover:text-emerald-900" href="{{ route('home', ['locale' => 'fr']) }}">View public site</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                    <strong>Please check the settings.</strong>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $emailValue = old(
                    'contact_emails',
                    is_array($settings['contact_emails']) ? implode(PHP_EOL, $settings['contact_emails']) : $settings['contact_emails']
                );
            @endphp

            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6 rounded-lg bg-white p-6 shadow-sm">
                @csrf
                @method('PUT')

                <section>
                    <h3 class="text-lg font-black text-gray-900">Identity and SEO</h3>
                    <div class="mt-4 grid gap-5">
                        <label class="grid gap-2 text-sm font-semibold text-gray-700">Organization name
                            <input class="rounded-md border-gray-300" name="organization_name" value="{{ old('organization_name', $settings['organization_name']) }}">
                        </label>
                        <label class="grid gap-2 text-sm font-semibold text-gray-700">Default meta description
                            <textarea class="rounded-md border-gray-300" rows="3" name="default_meta_description">{{ old('default_meta_description', $settings['default_meta_description']) }}</textarea>
                        </label>
                    </div>
                </section>

                <section class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-black text-gray-900">Contact information</h3>
                    <div class="mt-4 grid gap-5 md:grid-cols-2">
                        <label class="grid gap-2 text-sm font-semibold text-gray-700 md:col-span-2">Address
                            <textarea class="rounded-md border-gray-300" rows="3" name="address">{{ old('address', $settings['address']) }}</textarea>
                        </label>
                        <label class="grid gap-2 text-sm font-semibold text-gray-700">Phone
                            <input class="rounded-md border-gray-300" name="phone" value="{{ old('phone', $settings['phone']) }}">
                        </label>
                        <label class="grid gap-2 text-sm font-semibold text-gray-700">WhatsApp number
                            <input class="rounded-md border-gray-300" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}">
                        </label>
                        <label class="grid gap-2 text-sm font-semibold text-gray-700 md:col-span-2">Contact emails
                            <textarea class="rounded-md border-gray-300" rows="3" name="contact_emails" placeholder="info@dedefund.org">{{ $emailValue }}</textarea>
                            <span class="text-xs font-medium text-gray-500">One email per line, or separated by commas.</span>
                        </label>
                    </div>
                </section>

                <section class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-black text-gray-900">Donation configuration</h3>
                    <div class="mt-4 grid gap-5">
                        <label class="grid gap-2 text-sm font-semibold text-gray-700">PayPal donation URL
                            <input class="rounded-md border-gray-300" type="url" name="paypal_url" value="{{ old('paypal_url', $settings['paypal_url']) }}">
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <input class="rounded border-gray-300 text-emerald-700" type="checkbox" name="show_bank_details" value="1" @checked(old('show_bank_details', $settings['show_bank_details']))>
                            Show bank transfer details on the donation page
                        </label>
                        <label class="grid gap-2 text-sm font-semibold text-gray-700">Bank details
                            <textarea class="rounded-md border-gray-300" rows="5" name="bank_details">{{ old('bank_details', $settings['bank_details']) }}</textarea>
                        </label>
                    </div>
                </section>

                <div class="flex items-center gap-3 border-t border-gray-200 pt-6">
                    <button class="rounded-md bg-emerald-700 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-800">Save website settings</button>
                    <a class="text-sm font-bold text-gray-600 hover:text-gray-900" href="{{ route('admin.dashboard') }}">Back to dashboard</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
