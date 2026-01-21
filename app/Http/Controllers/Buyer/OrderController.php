<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Checkout / beli tiket
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'tickets' => 'required|array',
            'tickets.*.id' => 'required|exists:tikets,id',
            'tickets.*.qty' => 'nullable|integer|min:0',
        ]);

        // Ambil hanya tiket yang qty > 0
        $selectedTickets = collect($request->tickets)
            ->filter(fn ($t) => isset($t['qty']) && $t['qty'] > 0);

        if ($selectedTickets->isEmpty()) {
            return back()->withErrors([
                'error' => 'Silakan pilih minimal satu tiket.'
            ]);
        }

        try {
            DB::transaction(function () use ($request, $selectedTickets) {

                $order = Order::create([
                    'user_id'     => auth()->id(),
                    'event_id'    => $request->event_id,
                    'order_date'  => now(),
                    'total_harga' => 0,
                ]);

                $total = 0;

                foreach ($selectedTickets as $ticketData) {
                    $ticket = Tiket::lockForUpdate()->findOrFail($ticketData['id']);

                    if ($ticket->stok < $ticketData['qty']) {
                        throw new \Exception(
                            "Stok tiket '{$ticket->tipe}' tidak mencukupi"
                        );
                    }

                    $subtotal = $ticket->harga * $ticketData['qty'];

                    DetailOrder::create([
                        'order_id'       => $order->id,
                        'tiket_id'       => $ticket->id,
                        'jumlah'         => $ticketData['qty'],
                        'subtotal_harga' => $subtotal,
                    ]);

                    $ticket->decrement('stok', $ticketData['qty']);
                    $total += $subtotal;
                }

                $order->update(['total_harga' => $total]);
            });

            return redirect()
                ->route('buyer.orders.history')
                ->with('success', 'Pembelian tiket berhasil 🎉');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Riwayat pembelian pembeli
     */
    public function history()
    {
        $orders = Order::with('event')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('buyer.orders.history', compact('orders'));
    }

    /**
     * Detail order pembeli
     */
    public function show($id)
    {
        $order = Order::with(['event', 'detailOrders.tiket'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('buyer.orders.show', compact('order'));
    }
}
