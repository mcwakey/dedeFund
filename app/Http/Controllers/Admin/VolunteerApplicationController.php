<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VolunteerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VolunteerApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $volunteers = VolunteerApplication::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('country'), fn ($query) => $query->where('country', 'like', '%'.$request->string('country').'%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.volunteers.index', compact('volunteers'));
    }

    public function show(VolunteerApplication $volunteer): View
    {
        return view('admin.volunteers.show', compact('volunteer'));
    }

    public function update(Request $request, VolunteerApplication $volunteer): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,reviewing,accepted,rejected,contacted'],
            'internal_notes' => ['nullable', 'string', 'max:4000'],
        ]);

        $volunteer->update($validated);

        return back()->with('status', 'Volunteer application updated.');
    }
}
