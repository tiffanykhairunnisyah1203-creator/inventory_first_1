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
    <style>
        .bg-white.overflow-hidden { border-radius: 1.25rem !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important; border: 1px solid #f1f5f9 !important; }
        h2.font-semibold.text-2xl { color: #1e293b; position: relative; padding-left: 1.25rem; display: flex; align-items: center; }
        h2.font-semibold.text-2xl::before { content: ''; position: absolute; left: 0; height: 1.5rem; width: 0.35rem; background: linear-gradient(to bottom, #4f46e5, #818cf8); border-radius: 1rem; }
        .btn-primary-gradient { background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important; transition: all 0.3s ease !important; }
        .search-input-custom { border-radius: 0.75rem; border: 1px solid #e2e8f0; padding: 0.5rem 1rem; transition: all 0.2s; }
    </style>

    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="font-semibold text-2xl text-gray-800">AHM Support</h2>
        <div class="flex flex-wrap items-center gap-3">
            <form action="<?php echo e(route('jenis.index')); ?>" method="GET" class="flex items-center gap-2">
                <input type="text" name="cari" value="<?php echo e(request('cari')); ?>" placeholder="Cari Item Description..." class="search-input-custom text-sm w-64">
                <button type="submit" class="px-5 py-2 btn-primary-gradient text-white font-bold rounded-xl text-sm shadow-sm">Cari</button>
            </form>
            <a href="<?php echo e(route('jenis.create')); ?>" class="px-5 py-2 btn-primary-gradient text-white font-bold rounded-xl text-sm shadow-md">+ Tambah Jenis Item</a>
        </div>
    </div>

    
    <?php if(session('sukses')): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl border border-green-200 auto-dismiss">
            <?php echo e(session('sukses')); ?>

        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl border border-red-200 auto-dismiss font-medium">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white overflow-hidden shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs uppercase tracking-wider">ITEM NO.</th>
                        <th class="px-6 py-4 text-xs uppercase tracking-wider">ITEM DESCRIPTION</th>
                        <th class="px-6 py-4 text-center text-xs uppercase tracking-wider">BEGINNING</th>
                        <th class="px-6 py-4 text-center text-xs uppercase tracking-wider">ORDER</th>
                        <th class="px-6 py-4 text-center text-xs uppercase tracking-wider">PACKING</th>
                        <th class="px-6 py-4 text-center text-xs uppercase tracking-wider">END STOCK</th>
                        <th class="px-6 py-4 text-center text-xs uppercase tracking-wider">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $jenis_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $transaksi = $item->barangs ?? collect();
                            $beginning = $item->beginning ?? 0;
                            $totalOrder = $transaksi->sum('order');
                            $totalPacking = $transaksi->sum('packing');
                            $endingStok = ($beginning + $totalOrder) - $totalPacking;
                        ?>

                        <tr class="border-b hover:bg-gray-50/50">
                            <td class="px-6 py-4 text-center font-medium text-gray-700"><?php echo e($item->item_no); ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold uppercase tracking-wider">
                                    <?php echo e($item->item_description); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-1 text-blue-600 bg-blue-50 rounded-xl font-semibold">
                                    <?php echo e(number_format($beginning, 0, ',', '.')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-1 text-green-600 bg-green-50 rounded-xl font-semibold">
                                    <?php echo e(number_format($totalOrder, 0, ',', '.')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-1 text-red-600 bg-red-50 rounded-xl font-semibold">
                                    <?php echo e(number_format($totalPacking, 0, ',', '.')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-1 text-gray-700 bg-gray-100 rounded-xl font-semibold">
                                    <?php echo e(number_format($endingStok, 0, ',', '.')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="<?php echo e(route('jenis.edit', $item->id)); ?>" class="p-2 bg-indigo-100 text-indigo-600 hover:bg-indigo-200 hover:text-indigo-900 rounded-lg transition-colors duration-200" title="Edit Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 italic">Belum ada data jenis barang.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($jenis_list->hasPages()): ?>
            <div class="p-4 bg-gray-50 border-t">
                <?php echo e($jenis_list->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mengatur timer 3000ms (3 detik)
            setTimeout(function() {
                // Mencari semua elemen dengan class 'auto-dismiss'
                let alerts = document.querySelectorAll('.auto-dismiss');
                
                alerts.forEach(function(alert) {
                    // Animasi memudar
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    
                    // Menghapus dari DOM setelah animasi selesai
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 3000);
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
<?php endif; ?><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/admin/jenis/index.blade.php ENDPATH**/ ?>