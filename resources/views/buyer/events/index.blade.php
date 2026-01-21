<x-app-layout>
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">
            🎉 Daftar Event
        </h1>

        <a href="{{ route('buyer.orders.history') }}"
        class="inline-flex items-center gap-2
                px-5 py-2.5
                bg-indigo-100 text-indigo-700
                rounded-lg font-semibold
                hover:bg-indigo-200 transition">
            📜 Riwayat Pembelian
        </a>
    </div>

    {{-- FILTER & SEARCH --}}
    <form method="GET"
          action="{{ route('buyer.events.index') }}"
          class="bg-white rounded-xl shadow p-4 mb-8
                 flex flex-col md:flex-row gap-4">

        {{-- Search --}}
        <div class="flex-1">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="🔍 Cari event..."
                class="w-full rounded-lg border-gray-300
                       text-gray-800
                       focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>

        {{-- Filter kategori --}}
        <div class="w-full md:w-1/4">
            <select name="kategori"
                class="w-full rounded-lg border-gray-300
                       text-gray-800
                       focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('kategori') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Button --}}
        <button
            type="submit"
            class="px-6 py-2 bg-indigo-600 text-black rounded-lg
                   font-semibold hover:bg-indigo-700 transition">
            Cari
        </button>
    </form>

    {{-- LIST EVENT --}}
    @if ($events->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($events as $event)
                <div class="bg-white rounded-xl shadow
                            hover:shadow-xl transition overflow-hidden group">

                    {{-- Gambar --}}
                    <div class="overflow-hidden">
                        <img
                            src="{{ asset('images/events/' . $event->gambar) }}"
                            alt="{{ $event->judul }}"
                            class="w-full h-48 object-cover
                                   group-hover:scale-105 transition duration-300">
                    </div>

                    {{-- Content --}}
                    <div class="p-5">

                        <span class="inline-block mb-2 px-3 py-1 text-xs
                                     bg-indigo-100 text-indigo-700
                                     rounded-full">
                            {{ $event->kategori->nama }}
                        </span>

                        <h2 class="text-lg font-bold text-gray-800 mb-2">
                            {{ $event->judul }}
                        </h2>

                        <div class="text-sm text-gray-500 space-y-1 mb-4">
                            <p>📍 {{ $event->lokasi }}</p>
                            <p>📅 {{ $event->tanggal_waktu->format('d M Y H:i') }}</p>
                        </div>

                        <a href="{{ route('buyer.events.show', $event->id) }}"
                           class="block text-center px-4 py-2 bg-indigo-600
                                  text-black rounded-lg font-semibold
                                  hover:bg-indigo-700 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $events->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center text-gray-500 py-12">
            Event tidak ditemukan 😢
        </div>
    @endif

</div>
</x-app-layout>
