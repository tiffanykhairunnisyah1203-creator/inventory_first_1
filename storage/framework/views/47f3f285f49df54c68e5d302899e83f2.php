<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control { border-radius: 0.375rem !important; padding: 0.5rem 0.75rem !important; }
        .ts-wrapper.single .ts-control { background-image: none !important; }
    </style>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="font-semibold text-2xl text-gray-800">Tambah Data Stok</h2>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-2xl">
        <form action="<?php echo e(route('barang.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Description</label>
                    <select name="item_description" id="item_description_select" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Cari & Pilih Item --</option>
                        <?php $__currentLoopData = $existingItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->item_description); ?>" 
                                    data-item-no="<?php echo e($item->item_no); ?>"
                                    <?php echo e(old('item_description') == $item->item_description ? 'selected' : ''); ?>>
                                <?php echo e($item->item_description); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item No</label>
                    <input type="text" name="item_no" id="item_no_input" 
                           value="<?php echo e(old('item_no')); ?>" 
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
                           value="<?php echo e(old('beginning', )); ?>" 
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
                <a href="<?php echo e(route('barang.index')); ?>" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50 transition-colors">Batal</a>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/admin/barang/create.blade.php ENDPATH**/ ?>