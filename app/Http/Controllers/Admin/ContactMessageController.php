<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $messages = ContactMessage::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message): View
    {
        if (! $message->read_at) {
            $message->update(['read_at' => now(), 'status' => 'read']);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,read,archived'],
        ]);

        $message->update($validated + [
            'read_at' => $validated['status'] === 'read' ? now() : $message->read_at,
        ]);

        return back()->with('status', 'Message updated.');
    }
}
