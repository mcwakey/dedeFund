<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\DonationIntent;
use App\Models\InternshipApplication;
use App\Models\VolunteerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FormSubmissionController extends Controller
{
    public function donation(Request $request, string $locale): RedirectResponse
    {
        app()->setLocale($locale);

        $validated = $request->validate([
            'donor_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:120'],
            'donation_method' => ['nullable', 'string', 'max:80'],
            'project_id' => ['nullable', 'integer', 'exists:projects,id'],
            'amount' => ['nullable', 'numeric', 'min:1'],
            'currency' => ['required', 'string', 'size:3'],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        DonationIntent::create($validated);

        return back()->with('status', $locale === 'fr'
            ? 'Merci. Votre intention de don a ete enregistree.'
            : 'Thank you. Your donation intent has been recorded.');
    }

    public function volunteer(Request $request, string $locale): RedirectResponse
    {
        app()->setLocale($locale);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:120'],
            'city' => ['nullable', 'string', 'max:120'],
            'contribution_type' => ['nullable', 'string', 'max:120'],
            'skills' => ['nullable', 'string', 'max:2000'],
            'availability' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:3000'],
            'documents.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
        ]);

        $validated['documents'] = $this->storeMultipleFiles($request, 'documents', 'applications/volunteers');
        VolunteerApplication::create($validated);

        return back()->with('status', $locale === 'fr'
            ? 'Merci. Votre candidature volontaire a ete recue.'
            : 'Thank you. Your volunteer application has been received.');
    }

    public function internship(Request $request, string $locale): RedirectResponse
    {
        app()->setLocale($locale);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:120'],
            'domain' => ['nullable', 'string', 'max:160'],
            'internship_type' => ['nullable', 'string', 'max:120'],
            'desired_start_date' => ['nullable', 'date'],
            'motivation' => ['nullable', 'string', 'max:4000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'study_certificate' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'institution_letter' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'other_documents.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
        ]);

        $validated['documents'] = $this->storeNamedFiles($request, [
            'cv',
            'study_certificate',
            'institution_letter',
        ], 'applications/internships');

        $validated['documents']['other_documents'] = $this->storeMultipleFiles($request, 'other_documents', 'applications/internships');
        $validated = Arr::except($validated, ['cv', 'study_certificate', 'institution_letter', 'other_documents']);

        InternshipApplication::create($validated);

        return back()->with('status', $locale === 'fr'
            ? 'Merci. Votre candidature de stage a ete recue.'
            : 'Thank you. Your internship application has been received.');
    }

    public function contact(Request $request, string $locale): RedirectResponse
    {
        app()->setLocale($locale);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:4000'],
            'context' => ['nullable', 'string', 'max:80'],
        ]);

        ContactMessage::create($validated);

        return back()->with('status', $locale === 'fr'
            ? 'Merci. Votre message a ete envoye.'
            : 'Thank you. Your message has been sent.');
    }

    private function storeMultipleFiles(Request $request, string $field, string $directory): array
    {
        $paths = [];

        foreach ($request->file($field, []) as $file) {
            if ($file) {
                $paths[] = $file->store($directory);
            }
        }

        return $paths;
    }

    private function storeNamedFiles(Request $request, array $fields, string $directory): array
    {
        $paths = [];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $paths[$field] = $request->file($field)->store($directory);
            }
        }

        return $paths;
    }
}
