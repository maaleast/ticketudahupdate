<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('kategori');

        // Search judul event
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $events = $query->orderBy('tanggal_waktu', 'asc')->paginate(6);
        $categories = Kategori::all();

        return view('buyer.events.index', compact('events', 'categories'));
    }

    public function show($id)
    {
        $event = Event::with(['tikets.tipeTiket', 'kategori'])->findOrFail($id);

        return view('buyer.events.show', compact('event'));
    }
}
