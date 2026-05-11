<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\ReturnApproved;
use App\Mail\ReturnRejected;
use App\Models\EmailLog;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReturnRequestController extends Controller
{
    public function index(Request $request)
    {
        $returns = ReturnRequest::with('user', 'order')
            ->latest()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->paginate(20);

        $stats = [
            'totali'   => ReturnRequest::count(),
            'pending'  => ReturnRequest::pending()->count(),
            'approved' => ReturnRequest::approved()->count(),
            'rejected' => ReturnRequest::rejected()->count(),
        ];

        return view('dashboard.returns.index', compact('returns', 'stats'));
    }

    public function show(ReturnRequest $returnRequest)
    {
        $returnRequest->load('user', 'order');
        return view('dashboard.returns.show', compact('returnRequest'));
    }

    public function update(Request $request, ReturnRequest $returnRequest)
    {
        $request->validate([
            'status'        => 'required|in:pending,approved,rejected,completed',
            'admin_notes'   => 'nullable|string',
            'refund_amount' => 'nullable|numeric|min:0',
        ]);

        $oldStatus = $returnRequest->status;
        $newStatus = $request->status;

        $returnRequest->update([
            'status'        => $newStatus,
            'admin_notes'   => $request->admin_notes,
            'refund_amount' => $request->refund_amount,
            'resolved_at'   => in_array($newStatus, ['approved', 'rejected']) ? now() : $returnRequest->resolved_at,
        ]);

        // Invia mail approvazione
        if ($oldStatus !== 'approved' && $newStatus === 'approved') {
            Mail::to($returnRequest->user->email)->queue(new ReturnApproved($returnRequest));
            EmailLog::create([
                'type'      => 'return_approved',
                'recipient' => $returnRequest->user->email,
                'subject'   => 'Reso approvato - Ordine #' . $returnRequest->order_number,
                'status'    => 'sent',
            ]);
        }

        // Invia mail rifiuto
        if ($oldStatus !== 'rejected' && $newStatus === 'rejected') {
            Mail::to($returnRequest->user->email)->queue(new ReturnRejected($returnRequest));
            EmailLog::create([
                'type'      => 'return_rejected',
                'recipient' => $returnRequest->user->email,
                'subject'   => 'Reso non approvato - Ordine #' . $returnRequest->order_number,
                'status'    => 'sent',
            ]);
        }

        return redirect()
            ->route('dashboard.returns.show', $returnRequest)
            ->with('success', 'Richiesta aggiornata!' . (
                $newStatus === 'approved' ? ' Email di approvazione inviata.' :
                ($newStatus === 'rejected' ? ' Email di rifiuto inviata.' : '')
            ));
    }
}