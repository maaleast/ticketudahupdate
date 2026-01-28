<x-layouts.admin title="Detail Lokasi">
    <div class="container mx-auto p-10">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">Detail Lokasi</h2>

                <div class="space-y-4">
                    <!-- ID -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">ID</span>
                        </label>
                        <p class="p-2 bg-gray-100 rounded">{{ $lokasi->id }}</p>
                    </div>

                    <!-- Nama Lokasi -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Nama Lokasi</span>
                        </label>
                        <p class="p-2 bg-gray-100 rounded">{{ $lokasi->nama_lokasi }}</p>
                    </div>

                    <!-- Created At -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Dibuat Pada</span>
                        </label>
                        <p class="p-2 bg-gray-100 rounded">{{ $lokasi->created_at->format('d M Y H:i:s') }}</p>
                    </div>

                    <!-- Updated At -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Diperbarui Pada</span>
                        </label>
                        <p class="p-2 bg-gray-100 rounded">{{ $lokasi->updated_at->format('d M Y H:i:s') }}</p>
                    </div>
                </div>

                <!-- Button -->
                <div class="card-actions justify-end mt-6">
                    <a href="{{ route('admin.lokasi.index') }}" class="btn btn-ghost">Kembali</a>
                    <a href="{{ route('admin.lokasi.edit', $lokasi->id) }}" class="btn btn-primary">Edit</a>
                    <button class="btn bg-red-500 text-white" onclick="openDeleteModal(this)" data-id="{{ $lokasi->id }}">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <dialog id="delete_modal" class="modal">
        <form method="POST" class="modal-box">
            @csrf
            @method('DELETE')

            <input type="hidden" name="lokasi_id" id="delete_lokasi_id">

            <h3 class="text-lg font-bold mb-4">Hapus Lokasi</h3>
            <p>Apakah Anda yakin ingin menghapus lokasi ini?</p>
            <div class="modal-action">
                <button class="btn btn-primary" type="submit">Hapus</button>
                <button class="btn" onclick="delete_modal.close()" type="reset">Batal</button>
            </div>
        </form>
    </dialog>

    <script>
        function openDeleteModal(button) {
            const id = button.dataset.id;
            const form = document.querySelector('#delete_modal form');
            document.getElementById("delete_lokasi_id").value = id;

            // Set action dengan parameter ID
            form.action = `/admin/lokasi/${id}`

            delete_modal.showModal();
        }
    </script>
</x-layouts.admin>
