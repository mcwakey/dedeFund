<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationIntent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationIntentController extends Controller
{
    public function index(Request $request): View
    {
        $donations = DonationIntent::query()
            ->with('project.translations')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.donations.index', compact('donations'));
    }

    public function show(DonationIntent $donation): View
    {
        $donation->load('project.translations');

        return view('admin.donations.show', compact('donation'));
    }

    public function update(Request $request, DonationIntent $donation): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,contacted,confirmed,rejected,closed'],
        ]);

        $donation->update($validated + [
            'contacted_at' => $validated['status'] === 'contacted' ? now() : $donation->contacted_at,
        ]);

        return back()->with('status', 'Donation intent updated.');
    }
}
