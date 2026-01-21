<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Header --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        📜 Riwayat Pembelian Tiket
    </h1>

    {{-- Success --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->count())

        {{-- TABLE (Desktop) --}}
        <div class="hidden md:block bg-white rounded-2xl shadow overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Event</th>
                        <th class="px-6 py-4 text-right">Total</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                {{ $order->order_date->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $order->event->judul }}
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-indigo-600">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('buyer.orders.show', $order->id) }}"
                                   class="inline-block px-4 py-2 bg-indigo-600 text-black
                                          rounded-lg text-sm font-semibold
                                          hover:bg-indigo-700 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- CARD (Mobile) --}}
        <div class="md:hidden space-y-4">
            @foreach ($orders as $order)
                <div class="bg-white rounded-2xl shadow p-5">

                    <div class="text-sm text-gray-500 mb-2">
                        {{ $order->order_date->format('d M Y H:i') }}
                    </div>

                    <h3 class="font-bold text-gray-800 mb-1">
                        {{ $order->event->judul }}
                    </h3>

                    <div class="flex items-center justify-between mt-4">
                        <span class="font-semibold text-indigo-600">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </span>

                        <a href="{{ route('buyer.orders.show', $order->id) }}"
                           class="px-4 py-2 bg-indigo-600 text-black rounded-lg
                                  text-sm font-semibold hover:bg-indigo-700 transition">
                            Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="text-center text-gray-500 py-12">
            Kamu belum melakukan pembelian tiket 😢
        </div>
    @endif

</div>
</x-app-layout>
