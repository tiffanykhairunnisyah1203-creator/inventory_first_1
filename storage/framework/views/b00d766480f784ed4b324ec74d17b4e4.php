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
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <div class="max-w-4xl mx-auto">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                <span class="bg-green-100 p-2 rounded-lg text-green-600">📥</span> 
                Update Stok Masuk (Order)
            </h2>

            <form action="<?php echo e(route('barang.storeOrder')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Barang yang Sudah Ada</label>
                        <select name="item_description" id="item_select" required class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 shadow-sm">
                            <option value="">-- Cari & Pilih Nama Barang --</option>
                            <?php $__currentLoopData = $existingItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->item_description); ?>" 
                                        data-item-no="<?php echo e($item->item_no); ?>"
                                        <?php echo e(old('item_description') == $item->item_description ? 'selected' : ''); ?>>
                                    <?php echo e($item->item_description); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Item No</label>
                            <input type="text" name="item_no" id="item_no" readonly class="w-full bg-gray-50 rounded-xl border-gray-200 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Total Stok Saat Ini</label>
                            <input type="text" id="current_stok" readonly class="w-full bg-indigo-50 rounded-xl border-gray-200 font-bold text-indigo-700">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Order Baru (Akan Ditambahkan)</label>
                        <input type="number" name="order" required min="1" placeholder="" class="w-full rounded-xl border-gray-300 focus:ring-green-500 shadow-sm py-3">
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg whitespace-nowrap">
                        Simpan & Update Stok
                    </button>
                    <a href="<?php echo e(route('barang.index')); ?>" class="w-full sm:w-auto inline-flex justify-center items-center bg-gray-100 text-gray-700 px-8 py-3 rounded-xl border border-gray-200 font-bold hover:bg-gray-200 transition whitespace-nowrap">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        // Inisialisasi Fitur Ketik/Cari
        const settings = {
            create: false,
            sortField: { field: "text", direction: "asc" }
        };
        const control = new TomSelect('#item_select', settings);

        // Event Listener untuk Auto-fill
        control.on('change', function(value) {
            const selectEl = document.getElementById('item_select');
            const selected = selectEl.options[selectEl.selectedIndex];
            
            document.getElementById('item_no').value = selected ? selected.getAttribute('data-item-no') : '';

            if(value) {
                fetch(`<?php echo e(route('barang.getstok')); ?>?item=${encodeURIComponent(value)}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('current_stok').value = data.stok;
                    });
            } else {
                document.getElementById('current_stok').value = '';
            }
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
<?php endif; ?><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/admin/barang/create-order.blade.php ENDPATH**/ ?>