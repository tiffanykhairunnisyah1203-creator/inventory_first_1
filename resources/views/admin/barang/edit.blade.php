<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="font-semibold text-2xl text-gray-800">Edit Data Stok</h2>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-2xl">
        <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Description</label>
                    <select name="item_description" id="item_description_select" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Pilih Item --</option>
                        @foreach($existingItems as $item)
                            <option value="{{ $item->item_description }}" 
                                    data-item-no="{{ $item->item_no }}"
                                    {{ (old('item_description', $barang->item_description) == $item->item_description) ? 'selected' : '' }}>
                                {{ $item->item_description }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item No</label>
                    <input type="text" name="item_no" id="item_no_input" 
                           value="{{ old('item_no', $barang->item_no) }}" 
                           placeholder="Otomatis..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-600 cursor-not-allowed" required readonly>
                </div>
            </div>

            <hr class="border-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Beginning</label>
                    <input type="number" name="beginning" id="beginning_input" value="{{ old('beginning', $barang->beginning) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-indigo-600">Ending Stok</label>
                    <input type="number" name="ending_stok" id="ending_stok_display" value="{{ $barang->ending_stok }}" class="mt-1 block w-full rounded-md border-indigo-200 bg-indigo-50 font-bold text-indigo-700 cursor-not-allowed" readonly>
                </div>
            </div>

            <input type="hidden" name="order" value="{{ $barang->order }}">
            <input type="hidden" name="packing" value="{{ $barang->packing }}">

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('barang.index') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-bold shadow-md">
                    Update Data Stok
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = document.getElementById('item_description_select');
            const itemNoInput = document.getElementById('item_no_input');
            const beginningInput = document.getElementById('beginning_input');
            const endingStokDisplay = document.getElementById('ending_stok_display');

            itemSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                itemNoInput.value = selected.getAttribute('data-item-no') || '';
            });

            function calculate() {
                endingStokDisplay.value = parseFloat(beginningInput.value) || 0;
            }

            beginningInput.addEventListener('input', calculate);
        });
    </script>
</x-admin-layout>