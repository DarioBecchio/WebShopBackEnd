<?php

namespace App\Http\Controllers;

use App\Mail\ContactAlert;
use App\Mail\ContactReceived;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'type'    => 'required|in:complaint,return,info,order,other',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $contact = ContactMessage::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'email'   => $request->email,
            'type'    => $request->type,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Conferma al cliente
        Mail::to($contact->email)->queue(new ContactReceived($contact));

        // Notifica interna all'admin
        Mail::to(config('mail.from.address'))->queue(new ContactAlert($contact));

        return back()->with('success', 'Messaggio inviato! Ti risponderemo entro 24-48 ore.');
    }
}