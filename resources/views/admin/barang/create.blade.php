<x-admin-layout>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control { border-radius: 0.375rem !important; padding: 0.5rem 0.75rem !important; }
        .ts-wrapper.single .ts-control { background-image: none !important; }
    </style>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="font-semibold text-2xl text-gray-800">Tambah Data Stok</h2>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-2xl">
        <form action="{{ route('barang.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Description</label>
                    <select name="item_description" id="item_description_select" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Cari & Pilih Item --</option>
                        @foreach($existingItems as $item)
                            <option value="{{ $item->item_description }}" 
                                    data-item-no="{{ $item->item_no }}"
                                    {{ old('item_description') == $item->item_description ? 'selected' : '' }}>
                                {{ $item->item_description }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item No</label>
                    <input type="text" name="item_no" id="item_no_input" 
                           value="{{ old('item_no') }}" 
                           placeholder="Otomatis..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-600 cursor-not-allowed" required readonly>
                    <p class="text-[10px] text-gray-400 mt-1">*Terisi otomatis</p>
                </div>
            </div>

            <hr class="border-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Beginning</label>
                    <input type="number" name="beginning" id="beginning_input" 
                           value="{{ old('beginning', ) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-indigo-600">Ending Stok</label>
                    <input type="number" name="ending_stok" id="ending_stok_display" value="0" 
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 focus:ring-indigo-500 cursor-not-allowed" required readonly>
                </div>
            </div>

            <input type="hidden" name="order" value="0">
            <input type="hidden" name="packing" value="0">

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('barang.index') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-bold shadow-md transition-colors">
                    Simpan Data Stok
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = document.getElementById('item_description_select');
            const itemNoInput = document.getElementById('item_no_input');
            const beginningInput = document.getElementById('beginning_input');
            const endingStokDisplay = document.getElementById('ending_stok_display');

            const ts = new TomSelect(itemSelect, {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: "-- Cari & Pilih Item --",
            });

            itemSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                const itemNo = selectedOption ? selectedOption.getAttribute('data-item-no') : '';
                
                itemNoInput.value = itemNo || '';

                if (selectedValue) {
                    fetch(`/barang/get-stok?item=${encodeURIComponent(selectedValue)}`)
                        .then(response => response.json())
                        .then(data => {
                            beginningInput.value = data.stok || 0;
                            calculateTotal();
                        })
                        .catch(error => console.error('Error fetching stock:', error));
                } else {
                    beginningInput.value = 0;
                    calculateTotal();
                }
            });

            function calculateTotal() {
                const awal = parseFloat(beginningInput.value) || 0;
                endingStokDisplay.value = awal;
            }

            beginningInput.addEventListener('input', calculateTotal);
        });
    </script>
</x-admin-layout>