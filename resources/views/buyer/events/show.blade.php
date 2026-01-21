<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- EVENT HEADER --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden mb-8">

        {{-- Banner --}}
        <div class="relative">
            <img
                src="{{ asset('images/events/' . $event->gambar) }}"
                alt="{{ $event->judul }}"
                class="w-full h-72 object-cover">

            <span class="absolute top-4 left-4 px-3 py-1 text-sm
                         bg-indigo-600 text-black rounded-full shadow">
                {{ $event->kategori->nama }}
            </span>
        </div>

        {{-- Info --}}
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-3">
                {{ $event->judul }}
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4
                        text-sm text-gray-600 mb-5">
                <div>📍 {{ $event->lokasi }}</div>
                <div>📅 {{ $event->tanggal_waktu->format('d M Y H:i') }}</div>
                <div>🎟️ {{ $event->tikets->count() }} Tipe Tiket</div>
            </div>

            <p class="text-gray-700 leading-relaxed">
                {{ $event->deskripsi }}
            </p>
        </div>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- FORM TIKET --}}
    <form method="POST" action="{{ route('buyer.checkout') }}">
        @csrf

        <input type="hidden" name="event_id" value="{{ $event->id }}">

        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                🎫 Pilih Tiket
            </h2>

            @if ($event->tikets->count())
                <div class="space-y-4">

                    @foreach ($event->tikets as $index => $ticket)
                        <div class="flex flex-col md:flex-row md:items-center
                                    md:justify-between gap-4
                                    border border-gray-200
                                    rounded-xl p-4">

                            {{-- Ticket info --}}
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">
                                    {{ $ticket->tipeTiket?->nama ?? 'Tipe Tidak Diketahui' }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Harga:
                                    <span class="font-semibold text-indigo-600">
                                        Rp {{ number_format($ticket->harga, 0, ',', '.') }}
                                    </span>
                                </p>

                                <p class="text-sm text-gray-500">
                                    Stok tersedia: {{ $ticket->stok }}
                                </p>
                            </div>

                            {{-- Qty --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden"
                                       name="tickets[{{ $index }}][id]"
                                       value="{{ $ticket->id }}">

                                <label class="text-sm text-gray-600">
                                    Jumlah
                                </label>

                                <input
                                    type="number"
                                    name="tickets[{{ $index }}][qty]"
                                    min="0"
                                    max="{{ $ticket->stok }}"
                                    value="0"
                                    class="w-24 rounded-lg border-gray-300
                                           text-gray-800
                                           text-center
                                           focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- Submit --}}
                <div class="mt-8 text-right">
                    <button type="submit"
                        class="px-8 py-3 bg-indigo-600 text-black
                               rounded-xl font-semibold
                               hover:bg-indigo-700 transition">
                        🛒 Beli Tiket
                    </button>
                </div>
            @else
                <p class="text-gray-500">
                    Tiket belum tersedia untuk event ini.
                </p>
            @endif

        </div>
    </form>

</div>
</x-app-layout>
