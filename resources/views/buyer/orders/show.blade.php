<x-app-layout>
<div class="max-w-4xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            🧾 Detail Pembelian
        </h1>

        <span class="px-4 py-2 text-sm rounded-full
                     bg-green-100 text-green-700">
            Berhasil
        </span>
    </div>

    {{-- Event Info --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-2">
            {{ $order->event->judul }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4
                    text-sm text-gray-600">
            <div>📍 {{ $order->event->lokasi }}</div>
            <div>📅 {{ $order->event->tanggal_waktu->format('d M Y H:i') }}</div>
            <div>🕒 Dibeli: {{ $order->order_date->format('d M Y H:i') }}</div>
        </div>
    </div>

    {{-- Ticket Table --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">
                🎟️ Tiket yang Dibeli
            </h3>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden md:block">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">Tipe Tiket</th>
                        <th class="px-6 py-3 text-right">Harga</th>
                        <th class="px-6 py-3 text-center">Jumlah</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->detailOrders as $detail)
                        <tr class="border-t border-gray-200">
                            <td class="px-6 py-3 font-medium text-gray-800">
                                {{ $detail->tiket->tipe }}
                            </td>
                            <td class="px-6 py-3 text-right">
                                Rp {{ number_format($detail->tiket->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ $detail->jumlah }}
                            </td>
                            <td class="px-6 py-3 text-right font-semibold text-indigo-600">
                                Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden divide-y divide-gray-200">
            @foreach ($order->detailOrders as $detail)
                <div class="p-5">
                    <h4 class="font-bold text-gray-800">
                        {{ $detail->tiket->tipe }}
                    </h4>
                    <div class="text-sm text-gray-500 mt-1">
                        Harga: Rp {{ number_format($detail->tiket->harga, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-500">
                        Jumlah: {{ $detail->jumlah }}
                    </div>
                    <div class="mt-2 font-semibold text-indigo-600">
                        Subtotal: Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="p-6 border-t border-gray-200 flex justify-end">
            <div class="text-right">
                <div class="text-sm text-gray-500">
                    Total Pembayaran
                </div>
                <div class="text-2xl font-bold text-indigo-600">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Back --}}
    <div class="mt-8">
        <a href="{{ route('buyer.orders.history') }}"
           class="inline-flex items-center gap-2
                  text-indigo-600 hover:text-indigo-800
                  font-semibold transition">
            ← Kembali ke Riwayat Pembelian
        </a>
    </div>

</div>
</x-app-layout>
