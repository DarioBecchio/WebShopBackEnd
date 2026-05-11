<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmed;
use App\Mail\OrderShipped;
use App\Models\EmailLog;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->latest()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('order_number', 'like', '%' . $request->search . '%'))
            ->paginate(20);

        $stats = [
            'totali'      => Order::count(),
            'pending'     => Order::pending()->count(),
            'processing'  => Order::processing()->count(),
            'shipped'     => Order::shipped()->count(),
        ];

        return view('dashboard.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items');
        return view('dashboard.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status'         => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
            'tracking_number'=> 'nullable|string|max:100',
            'notes'          => 'nullable|string',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status'          => $newStatus,
            'tracking_number' => $request->tracking_number,
            'notes'           => $request->notes,
            'shipped_at'      => $newStatus === 'shipped' && $oldStatus !== 'shipped' ? now() : $order->shipped_at,
        ]);

        // Invia mail conferma ordine quando passa a "processing"
        if ($oldStatus === 'pending' && $newStatus === 'processing') {
            Mail::to($order->user->email)->queue(new OrderConfirmed($order));
            EmailLog::create([
                'type'      => 'order_confirmed',
                'recipient' => $order->user->email,
                'subject'   => 'Conferma ordine #' . $order->order_number,
                'status'    => 'sent',
            ]);
        }

        // Invia mail spedizione quando passa a "shipped"
        if ($oldStatus !== 'shipped' && $newStatus === 'shipped') {
            Mail::to($order->user->email)->queue(new OrderShipped($order));
            EmailLog::create([
                'type'      => 'order_shipped',
                'recipient' => $order->user->email,
                'subject'   => 'Ordine spedito #' . $order->order_number,
                'status'    => 'sent',
            ]);
        }

        return redirect()
            ->route('dashboard.orders.show', $order)
            ->with('success', 'Ordine aggiornato! ' . ($newStatus === 'shipped' ? 'Email di spedizione inviata.' : ''));
    }
}