<x-admin-layout>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <div class="max-w-4xl mx-auto">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-red-600 mb-6 flex items-center gap-3">
                <span class="bg-red-100 p-2 rounded-lg text-red-600">📤</span> 
                Update Stok Keluar (Packing)
            </h2>

            <form action="{{ route('barang.storePacking') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Barang</label>
                        <select name="item_description" id="item_select_packing" required class="w-full rounded-xl border-gray-300 focus:ring-red-500 shadow-sm">
                            <option value="">-- Cari & Pilih Barang --</option>
                            @foreach($existingItems as $item)
                                <option value="{{ $item->item_description }}" 
                                        data-item-no="{{ $item->item_no }}"
                                        {{ old('item_description') == $item->item_description ? 'selected' : '' }}>
                                    {{ $item->item_description }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Item No</label>
                            <input type="text" name="item_no" id="item_no" readonly class="w-full bg-gray-50 rounded-xl border-gray-200 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Sisa Stok Saat Ini</label>
                            <input type="text" id="current_stok" readonly class="w-full bg-green-50 rounded-xl border-gray-200 font-bold text-green-700">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Packing/Keluar</label>
                        <input type="number" name="packing" required min="1" class="w-full rounded-xl border-gray-300 focus:ring-red-500 shadow-sm py-3">
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center bg-red-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-red-700 transition shadow-lg whitespace-nowrap">
                        Simpan & Kurangi Stok
                    </button>
                    <a href="{{ route('barang.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center bg-gray-100 text-gray-700 px-8 py-3 rounded-xl border border-gray-200 font-bold hover:bg-gray-200 transition whitespace-nowrap">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        // Inisialisasi Fitur Ketik/Cari
        const controlPacking = new TomSelect('#item_select_packing', {
            create: false,
            sortField: { field: "text", direction: "asc" }
        });

        // Event Listener untuk Auto-fill
        controlPacking.on('change', function(value) {
            const selectEl = document.getElementById('item_select_packing');
            const selected = selectEl.options[selectEl.selectedIndex];
            
            document.getElementById('item_no').value = selected ? selected.getAttribute('data-item-no') : '';

            if(value) {
                fetch(`{{ route('barang.getstok') }}?item=${encodeURIComponent(value)}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('current_stok').value = data.stok;
                    });
            } else {
                document.getElementById('current_stok').value = '';
            }
        });
    </script>
</x-admin-layout>