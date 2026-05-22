<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $internships = InternshipApplication::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('domain'), fn ($query) => $query->where('domain', 'like', '%'.$request->string('domain').'%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.internships.index', compact('internships'));
    }

    public function show(InternshipApplication $internship): View
    {
        return view('admin.internships.show', compact('internship'));
    }

    public function update(Request $request, InternshipApplication $internship): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,reviewing,accepted,rejected,contacted'],
            'internal_notes' => ['nullable', 'string', 'max:4000'],
        ]);

        $internship->update($validated);

        return back()->with('status', 'Internship application updated.');
    }
}
