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
        .bg-white.overflow-hidden { border-radius: 1.25rem !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025) !important; border: 1px solid #f1f5f9 !important; }
        h2.font-semibold.text-2xl { color: #1e293b; letter-spacing: -0.025em; position: relative; padding-left: 1.25rem; display: flex; align-items: center; }
        h2.font-semibold.text-2xl::before { content: ''; position: absolute; left: 0; height: 1.5rem; width: 0.35rem; background: linear-gradient(to bottom, #4f46e5, #818cf8); border-radius: 1rem; }
        a.bg-indigo-600, button.bg-indigo-600 { background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important; box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.3) !important; border-radius: 0.5rem !important; padding: 0.625rem 1.5rem !important; transition: all 0.3s ease !important; letter-spacing: 0.025em; }
        a.bg-indigo-600:hover, button.bg-indigo-600:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4) !important; }
        thead.bg-gray-50 { background-color: #f8fafc !important; border-bottom: 2px solid #e2e8f0 !important; }
        th.px-6.py-4 { color: #64748b !important; font-size: 0.75rem !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; font-weight: 700 !important; }
        tbody tr { transition: all 0.2s ease-in-out; }
        tbody tr:hover { background-color: #f8fafc !important; transform: scale(1.001); }
        td span.bg-blue-100 { background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%) !important; color: #312e81 !important; padding: 0.35rem 1rem !important; border-radius: 9999px !important; box-shadow: inset 0 1px 2px rgba(255,255,255,0.8) !important; border: 1px solid #a5b4fc !important; letter-spacing: 0.025em; font-weight: 600; }
    </style>

    <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
        <h2 class="font-semibold text-2xl text-gray-800">Manajemen Stok Barang</h2>
        
        <div class="flex flex-wrap items-center gap-3">
            <form action="<?php echo e(route('barang.index')); ?>" method="GET" class="flex items-center gap-2">
                <input type="text" 
                       name="item_description" 
                       value="<?php echo e(request('item_description')); ?>" 
                       placeholder="Cari Item Description..." 
                       oninput="if(this.value === '') this.form.submit();"
                       class="border border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5 px-3 w-48 sm:w-56 text-gray-600"> 
                
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg text-sm hover:bg-indigo-700 transition duration-150 ease-in-out shadow-sm">
                    Cari
                </button>
            </form>

            <a href="<?php echo e(route('barang.create')); ?>" class="px-4 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg text-sm hover:bg-indigo-700 transition duration-150 ease-in-out shadow-sm whitespace-nowrap">
                + Tambah Data
            </a>
        </div>
    </div>
    
    
    <?php if(session('success')): ?>
        <div id="success-alert" class="mb-4 p-4 bg-green-100 text-green-700 rounded-md shadow-sm border border-green-200 transition-opacity duration-500">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="bg-gray-50 text-gray-500 font-medium border-b">
                    <tr>
                        <th class="px-6 py-4">Ket.Tgl</th>
                        <th class="px-6 py-4">Item No.</th>
                        <th class="px-6 py-4">Item Description</th>
                        <th class="px-6 py-4 text-center">Beginning</th>
                        <th class="px-6 py-4 text-center">Order</th>
                        <th class="px-6 py-4 text-center">Packing</th>
                        <th class="px-6 py-4 text-center">End Stok</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            <?php echo e($item->created_at->format('d/m/Y')); ?>

                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            <?php echo e($item->item_no); ?> 
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                <?php echo e($item->item_description); ?> 
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-4 py-1 text-blue-600 bg-blue-50 rounded-xl font-semibold">
                                <?php echo e($item->beginning); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-4 py-1 text-green-600 bg-green-50 rounded-xl font-semibold">
                                <?php echo e($item->order); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-4 py-1 text-red-600 bg-red-50 rounded-xl font-semibold">
                                <?php echo e($item->packing); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-4 py-1 text-gray-700 bg-gray-100 rounded-xl font-bold">
                                <?php echo e($item->ending_stok); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-center flex justify-center gap-3">
                            
                            <a href="<?php echo e(route('barang.riwayat', $item->item_no)); ?>" title="Lihat Riwayat" class="p-2 bg-green-100 text-green-600 hover:bg-green-200 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </a>
                            <a href="<?php echo e(route('barang.edit', $item->id)); ?>" title="Edit" class="p-2 bg-indigo-100 text-indigo-600 hover:bg-indigo-200 hover:text-indigo-900 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            
                            <form action="<?php echo e(route('barang.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Hapus data ini?');" class="inline">
                                <?php echo csrf_field(); ?> 
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" title="Hapus" class="p-2 bg-red-100 text-red-500 hover:bg-red-200 hover:text-red-700 rounded-lg cursor-pointer transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-400">Belum ada data barang.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($barangs->hasPages()): ?>
            <div class="p-4 border-t border-gray-100">
                <?php echo e($barangs->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertBox = document.getElementById('success-alert');
            
            if (alertBox) {
                // Menunggu 3 detik (3000 ms) sebelum mulai memudar
                setTimeout(function () {
                    alertBox.style.opacity = '0';
                    
                    // Menunggu efek transisi (500 ms) selesai sebelum menghapus dari DOM
                    setTimeout(function () {
                        alertBox.remove();
                    }, 500);
                }, 3000); 
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
<?php endif; ?><?php /**PATH C:\inventory_system_pkl_project\Gudang\resources\views/admin/barang/index.blade.php ENDPATH**/ ?>