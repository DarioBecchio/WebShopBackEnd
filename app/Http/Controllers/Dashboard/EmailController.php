<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewsletterJob;
use App\Models\EmailLog;
use App\Models\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    // Pannello principale
    public function index()
    {
        $stats = [
            'totali'       => EmailLog::count(),
            'newsletter'   => EmailLog::newsletter()->count(),
            'transazionali'=> EmailLog::transactional()->count(),
            'fallite'      => EmailLog::where('status', 'failed')->count(),
            'iscritti'     => User::where('newsletter', true)->count(),
        ];

        $recenti = EmailLog::latest()->take(5)->get();

        return view('dashboard.email.index', compact('stats', 'recenti'));
    }

    // Form newsletter
    public function newsletter()
    {
        $iscritti = User::where('newsletter', true)->count();
        return view('dashboard.email.newsletter', compact('iscritti'));
    }

    // Invia newsletter
    public function sendNewsletter(Request $request)
    {
        $request->validate([
            'subject'   => 'required|string|max:255',
            'body'      => 'required|string',
            'cta_url'   => 'nullable|url',
            'cta_label' => 'nullable|string|max:100',
        ]);

        SendNewsletterJob::dispatch(
            $request->subject,
            $request->body,
            $request->cta_url ?? '',
            $request->cta_label ?? 'Scopri di più'
        );

        return redirect()
            ->route('dashboard.email.index')
            ->with('success', 'Newsletter in invio a tutti gli iscritti!');
    }

    // Log email
    public function logs(Request $request)
    {
        $logs = EmailLog::latest()
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->paginate(20);

        return view('dashboard.email.logs', compact('logs'));
    }

    // Template
    public function templates()
    {
        $templates = [
            ['nome' => 'Benvenuto',           'file' => 'emails.users.welcome',      'tipo' => 'Transazionale'],
            ['nome' => 'Account eliminato',   'file' => 'emails.users.deleted',      'tipo' => 'Transazionale'],
            ['nome' => 'Conferma ordine',     'file' => 'emails.orders.confirmed',   'tipo' => 'Ordine'],
            ['nome' => 'Ordine spedito',      'file' => 'emails.orders.shipped',     'tipo' => 'Ordine'],
            ['nome' => 'Newsletter',          'file' => 'emails.newsletter.main',    'tipo' => 'Marketing'],
        ];

        return view('dashboard.email.templates', compact('templates'));
    }
}