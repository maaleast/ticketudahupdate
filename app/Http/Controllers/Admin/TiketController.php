<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = request()->validate([
            'event_id' => 'required|exists:events,id',
            'tipe_tiket_id' => 'required|exists:tipe_tikets,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        // Create the ticket
        Tiket::create([
            'event_id' => $validatedData['event_id'],
            'tipe_tiket_id' => $validatedData['tipe_tiket_id'],
            'harga' => $validatedData['harga'],
            'stok' => $validatedData['stok'],
        ]);

        return redirect()->route('admin.events.show', $validatedData['event_id'])->with('success', 'Ticket berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Tiket::findOrFail($id);

        $validatedData = $request->validate([
            'tipe_tiket_id' => 'required|exists:tipe_tikets,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $ticket->update([
            'tipe_tiket_id' => $validatedData['tipe_tiket_id'],
            'harga' => $validatedData['harga'],
            'stok' => $validatedData['stok'],
        ]);

        return redirect()->route('admin.events.show', $ticket->event_id)->with('success', 'Ticket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Tiket::findOrFail($id);
        $eventId = $ticket->event_id;
        $ticket->delete();

        return redirect()->route('admin.events.show', $eventId)->with('success', 'Ticket berhasil dihapus.');
    }
}
