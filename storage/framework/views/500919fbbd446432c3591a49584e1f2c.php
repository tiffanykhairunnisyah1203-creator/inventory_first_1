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
    <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800">Riwayat Stok Barang</h2>
            <p class="text-sm text-gray-500 mt-1">Item No: <span class="font-bold text-indigo-600"><?php echo e($item_no); ?></span></p>
        </div>
        
        <div class="flex items-center gap-2">
            <a href="<?php echo e(route('barang.index')); ?>" class="px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-200 transition duration-150 ease-in-out border border-gray-300">
                &larr; Kembali
            </a>
        </div>
    </div>

    <?php if(session('sukses')): ?>
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            <?php echo e(session('sukses')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="bg-gray-50 text-gray-500 font-medium border-b">
                    <tr>
                        <th class="px-6 py-4">Tanggal & Waktu</th>
                        <th class="px-6 py-4">Jenis Transaksi</th>
                        <th class="px-6 py-4 text-center">Jumlah</th>
                        <th class="px-6 py-4 text-center">Stok Sebelum</th>
                        <th class="px-6 py-4 text-center">Stok Sesudah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            <?php echo e($log->created_at->format('d/m/Y H:i:s')); ?>

                        </td>
                        <td class="px-6 py-4">
                            <?php if($log->jenis == 'awal'): ?>
                                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold uppercase">Awal</span>
                            <?php elseif($log->jenis == 'order'): ?>
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-semibold uppercase">Order (Masuk)</span>
                            <?php else: ?>
                                <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-semibold uppercase">Packing (Keluar)</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-gray-800">
                            <?php echo e($log->jumlah); ?>

                        </td>
                        <td class="px-6 py-4 text-center text-gray-600">
                            <?php echo e($log->stok_sebelum); ?>

                        </td>
                        <td class="px-6 py-4 text-center font-bold text-indigo-600">
                            <?php echo e($log->stok_sesudah); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-400">Belum ada riwayat transaksi untuk barang ini.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/admin/barang/riwayat.blade.php ENDPATH**/ ?>