<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipeTiket;
use Illuminate\Http\Request;

class TipeTiketController extends Controller
{
    public function index()
    {
        $tipeTikets = TipeTiket::all();
        return view('admin.tipe_tiket.index', compact('tipeTikets'));
    }

    public function create()
    {
        // handled with modal in index view
    }

    public function store(Request $request)
    {
        $payload = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        if (!isset($payload['nama'])) {
            return redirect()->route('admin.tipe-tikets.index')->with('error', 'Nama tipe tiket wajib diisi.');
        }

        TipeTiket::create([ 'nama' => $payload['nama'] ]);

        return redirect()->route('admin.tipe-tikets.index')->with('success', 'Tipe tiket berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // not used
    }

    public function edit(string $id)
    {
        // handled with modal in index view
    }

    public function update(Request $request, string $id)
    {
        $payload = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        if (!isset($payload['nama'])) {
            return redirect()->route('admin.tipe-tikets.index')->with('error', 'Nama tipe tiket wajib diisi.');
        }

        $tipe = TipeTiket::findOrFail($id);
        $tipe->nama = $payload['nama'];
        $tipe->save();

        return redirect()->route('admin.tipe-tikets.index')->with('success', 'Tipe tiket berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        TipeTiket::destroy($id);
        return redirect()->route('admin.tipe-tikets.index')->with('success', 'Tipe tiket berhasil dihapus.');
    }
}
