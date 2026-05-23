<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => $this->settings(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:100'],
            'contact_emails' => ['nullable', 'string', 'max:1000'],
            'whatsapp_number' => ['nullable', 'string', 'max:100'],
            'paypal_url' => ['nullable', 'url', 'max:2048'],
            'bank_details' => ['nullable', 'string', 'max:5000'],
            'show_bank_details' => ['nullable', 'boolean'],
            'default_meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        SiteSetting::putValue('organization_name', ($validated['organization_name'] ?? null) ?: 'DedeFund', 'general');
        SiteSetting::putValue('default_meta_description', ($validated['default_meta_description'] ?? null) ?: null, 'seo');
        SiteSetting::putValue('address', ($validated['address'] ?? null) ?: null, 'contact');
        SiteSetting::putValue('phone', ($validated['phone'] ?? null) ?: null, 'contact');
        SiteSetting::putValue('contact_emails', $this->emails($validated['contact_emails'] ?? ''), 'contact');
        SiteSetting::putValue('whatsapp_number', ($validated['whatsapp_number'] ?? null) ?: null, 'contact');
        SiteSetting::putValue('paypal_url', ($validated['paypal_url'] ?? null) ?: null, 'donations');
        SiteSetting::putValue('bank_details', ($validated['bank_details'] ?? null) ?: null, 'donations');
        SiteSetting::putValue('show_bank_details', $request->boolean('show_bank_details'), 'donations');

        return back()->with('status', 'Website settings updated.');
    }

    private function settings(): array
    {
        return [
            'organization_name' => SiteSetting::getValue('organization_name', 'DedeFund'),
            'default_meta_description' => SiteSetting::getValue('default_meta_description', 'DedeFund works for dignity, justice, peace, and a world without poverty.'),
            'address' => SiteSetting::getValue('address', '897 Middle River RD, Middle River, MD 21220, USA'),
            'phone' => SiteSetting::getValue('phone', '+1 240 353 8332'),
            'contact_emails' => SiteSetting::getValue('contact_emails', ['info@dedefund.org', 'dedeusca@gmail.com']),
            'whatsapp_number' => SiteSetting::getValue('whatsapp_number', '+12403538332'),
            'paypal_url' => SiteSetting::getValue('paypal_url'),
            'bank_details' => SiteSetting::getValue('bank_details'),
            'show_bank_details' => SiteSetting::getValue('show_bank_details', false),
        ];
    }

    private function emails(string $value): array
    {
        return collect(preg_split('/[\r\n,]+/', $value))
            ->map(fn ($email) => trim($email))
            ->filter()
            ->values()
            ->all();
    }
}
