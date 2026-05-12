<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::with('user')
            ->latest()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->paginate(20);

        $stats = [
            'totali'      => ContactMessage::count(),
            'new'         => ContactMessage::new()->count(),
            'in_progress' => ContactMessage::inProgress()->count(),
            'resolved'    => ContactMessage::resolved()->count(),
        ];

        return view('dashboard.contacts.index', compact('messages', 'stats'));
    }

    public function show(ContactMessage $contact)
    {
        // Segna come letto
        if (!$contact->read_at) {
            $contact->update([
                'read_at' => now(),
                'status'  => $contact->status === 'new' ? 'in_progress' : $contact->status,
            ]);
        }

        return view('dashboard.contacts.show', compact('contact'));
    }

    public function update(Request $request, ContactMessage $contact)
    {
        $request->validate([
            'status'      => 'required|in:new,in_progress,resolved',
            'admin_reply' => 'nullable|string',
        ]);

        $contact->update([
            'status'       => $request->status,
            'admin_reply'  => $request->admin_reply,
            'resolved_at'  => $request->status === 'resolved' ? now() : $contact->resolved_at,
        ]);

        return redirect()
            ->route('dashboard.contacts.show', $contact)
            ->with('success', 'Messaggio aggiornato!');
    }
}