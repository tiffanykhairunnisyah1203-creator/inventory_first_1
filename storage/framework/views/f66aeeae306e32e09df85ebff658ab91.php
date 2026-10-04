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
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-bold text-2xl text-gray-800">Top Up Saldo</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <div class="mb-8 border-l-4 border-indigo-600 pl-4">
                    <h3 class="text-xl font-bold text-gray-900">Form Top Up Saldo</h3>
                    <p class="text-gray-500 text-sm mt-1">Silakan isi detail TopUp saldo operasional di bawah ini.</p>
                </div>

                <form action="<?php echo e(route('admin.keuangan.store_topup')); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    
                    <div>
                        <label for="jumlah_topup" class="block text-sm font-semibold text-gray-700 mb-2">Nominal Top Up</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-bold"></span>
                            <input type="number" name="jumlah" id="jumlah_topup" required 
                                class="w-full pl-4 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900 transition-all outline-none"
                                placeholder="Rp.">
                        </div>
                    </div>

                    <div>
                        <label for="sumber_saldo" class="block text-sm font-semibold text-gray-700 mb-2">Sumber Saldo setiap bulan</label>
                        <select name="keterangan" id="sumber_saldo" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900 transition-all outline-none cursor-pointer">
                            <option value="" disabled selected>-- Pilih bulan --</option>
                            <?php
                                $bulans = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            ?>
                            <?php $__currentLoopData = $bulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($bulan); ?>"><?php echo e($bulan); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" id="catatan" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900 transition-all outline-none"
                            placeholder="Tambahkan detail jika perlu..."></textarea>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end items-center gap-3 pt-6 mt-4 border-t border-gray-100">
                        <a href="<?php echo e(route('admin.keuangan.index')); ?>" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors whitespace-nowrap">
                            Konfirmasi Top Up
                        </button>
                    </div>
                </form>
            </div>
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
<?php endif; ?><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/admin/keuangan/topup.blade.php ENDPATH**/ ?>