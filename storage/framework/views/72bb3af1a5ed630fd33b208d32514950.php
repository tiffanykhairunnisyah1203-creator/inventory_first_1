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
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
            <div class="flex items-center">
                <div style="width: 8px; height: 32px; background-color: #4f46e5; border-radius: 9999px; margin-right: 12px;"></div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                    <?php echo e(__('Manajemen Keuangan')); ?>

                </h2>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="<?php echo e(route('admin.keuangan.index')); ?>" class="px-4 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold rounded-lg shadow-sm hover:bg-indigo-100 transition">
                    Dashboard Keuangan
                </a>
                
                <a href="<?php echo e(route('admin.keuangan.pencairan')); ?>" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-bold rounded-lg shadow-sm hover:bg-gray-50 transition">
                    Pencairan Saldo
                </a>
                <a href="<?php echo e(route('admin.keuangan.topup')); ?>" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg shadow-sm hover:bg-blue-700 transition">
                    + Top Up Saldo
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <style>
        .wallet-card-glass {
            background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
            border-radius: 2rem;
            padding: 2.5rem;
            color: white;
            box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.4);
            position: relative;
            overflow: hidden;
        }
        .wallet-card-glass::after {
            content: '';
            position: absolute;
            bottom: -20%; right: -10%;
            width: 300px; height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }
        .stat-item-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1.25rem;
            padding: 1.25rem;
            transition: all 0.2s ease;
        }
        .stat-item-glass:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.12);
        }
        .custom-form-input {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            color: #1f2937;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .custom-form-input:focus {
            outline: none;
            border-color: #6366f1;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        .action-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .action-card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
        .custom-table-header {
            background-color: #f8fafc;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.75rem;
            color: #64748b;
        }
        .search-container {
            position: relative;
        }
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        .search-input {
            padding-left: 3rem;
        }
        .btn-tutup-buku {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            box-shadow: 0 10px 20px -5px rgba(225, 29, 72, 0.4);
        }
        .btn-tutup-buku:hover {
            box-shadow: 0 15px 25px -5px rgba(225, 29, 72, 0.5);
        }
    </style>

    
    <div class="mb-6 flex justify-between items-center mt-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="flex items-center">
            <div style="width: 8px; height: 32px; background-color: #4f46e5; border-radius: 9999px; margin-right: 12px;"></div>
            <h2 class="font-semibold text-2xl text-gray-800">Manajemen Keuangan Delivery</h2>
        </div>

        
        <form id="formArsip" action="<?php echo e(route('admin.keuangan.arsip')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="button" onclick="confirmArsip()" class="btn-tutup-buku px-6 py-3 text-white font-black rounded-2xl hover:scale-105 active:scale-95 transition-all flex items-center gap-3 border-2 border-white/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span class="tracking-wide uppercase text-sm">Tutup Buku (Arsip)</span>
            </button>
        </form>
    </div>

    
    <?php if(session('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="flex items-center p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-emerald-800">
                        <?php echo e(session('success')); ?>

                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalc9f5080dae57e3eaabaf8eca63194c75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc9f5080dae57e3eaabaf8eca63194c75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notif-popup','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notif-popup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc9f5080dae57e3eaabaf8eca63194c75)): ?>
<?php $attributes = $__attributesOriginalc9f5080dae57e3eaabaf8eca63194c75; ?>
<?php unset($__attributesOriginalc9f5080dae57e3eaabaf8eca63194c75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc9f5080dae57e3eaabaf8eca63194c75)): ?>
<?php $component = $__componentOriginalc9f5080dae57e3eaabaf8eca63194c75; ?>
<?php unset($__componentOriginalc9f5080dae57e3eaabaf8eca63194c75); ?>
<?php endif; ?>

    <div class="py-2 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
        
        
        <div class="wallet-card-glass">
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-indigo-200 text-sm font-bold uppercase tracking-[0.2em] mb-2">Total Saldo <?php echo e(request('bulan') ? 'Bulan ' . date('F Y', strtotime(request('bulan'))) : 'Tersedia'); ?></p>
                    <h1 class="text-5xl md:text-6xl font-black tracking-tight mb-4">
                        Rp <?php echo e(number_format($saldoTersedia, 0, ',', '.')); ?>

                    </h1>
                </div>
            </div>

            <div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-10">
                <div class="stat-item-glass border-l-4 border-l-emerald-400">
                    <p class="text-indigo-200 text-xs font-semibold uppercase mb-1">Pemasukan Manual</p>
                    <p class="font-bold text-xl text-emerald-300">+ Rp <?php echo e(number_format($pemasukanManual, 0, ',', '.')); ?></p>
                </div>

                <div class="stat-item-glass bg-white/20 border-l-4 border-l-rose-400">
                    <p class="text-indigo-200 text-xs font-semibold uppercase mb-1">Total Pengeluaran</p>
                    <p class="font-bold text-xl text-rose-300">
                        - Rp <?php echo e(number_format(($totalPenarikanSolar ?? 0) + ($totalPenarikanPettyCash ?? 0), 0, ',', '.')); ?>

                    </p>
                </div>

                <div class="stat-item-glass">
                    <p class="text-indigo-200 text-xs font-semibold uppercase mb-1">Operasional Solar</p>
                    <p class="font-bold text-xl text-orange-300">- Rp <?php echo e(number_format($totalPenarikanSolar ?? 0, 0, ',', '.')); ?></p>
                </div>

                <div class="stat-item-glass">
                    <p class="text-indigo-200 text-xs font-semibold uppercase mb-1">Operasional Petty Cash</p>
                    <p class="font-bold text-xl text-pink-300">- Rp <?php echo e(number_format($totalPenarikanPettyCash ?? 0, 0, ',', '.')); ?></p>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden action-card">
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                <h3 class="font-bold text-gray-800">Log Aktivitas Keuangan</h3>
                <span class="text-xs font-bold <?php echo e(request('bulan') ? 'text-amber-600 bg-amber-100' : 'text-gray-400 bg-gray-100'); ?> px-3 py-1 rounded-full uppercase tracking-widest">
                    <?php echo e(request('bulan') ? 'DATA ARSIP' : 'DATA REAL-TIME'); ?>

                </span>
            </div>
            
            <div class="px-8 py-4 bg-gray-50 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <form method="GET" action="<?php echo e(route('admin.keuangan.index')); ?>" class="flex flex-col md:flex-row gap-4 w-full">
                    <div class="search-container flex-1">
                        <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" 
                               name="search" 
                               class="search-input custom-form-input" 
                               placeholder="Cari berdasarkan keterangan atau tanggal transaksi..." 
                               value="<?php echo e(request('search')); ?>"
                               oninput="if(this.value === '') this.form.submit();">
                    </div>
                    
                    <div class="flex gap-2">
                        <input type="month" name="bulan" 
                               class="custom-form-input w-48 text-gray-600" 
                               value="<?php echo e(request('bulan')); ?>" 
                               title="Pilih bulan untuk melihat arsip"
                               onchange="this.form.submit()">
                        
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-sm">
                            Cari
                        </button>
                    </div>
                </form>

                
                <?php if(request('bulan')): ?>
                    <form action="<?php echo e(route('admin.keuangan.destroyArsip', ['periode' => request('bulan')])); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh arsip dan saldo di bulan ini? Data tidak dapat dikembalikan.')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-sm transition-all whitespace-nowrap">
                            Hapus Arsip Bulan Ini
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="custom-table-header border-b border-gray-100">
                            <th class="px-8 py-4">Waktu Transaksi</th>
                            <th class="px-8 py-4">Deskripsi & Kategori</th>
                            <th class="px-8 py-4 text-right">Nominal</th>
                            <th class="px-8 py-4 text-center">Status</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="text-sm font-bold text-slate-700"><?php echo e($item->created_at->format('d M Y')); ?></div>
                                    <div class="text-[11px] text-slate-400 font-medium"><?php echo e($item->created_at->format('H:i')); ?> WIB</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <div class="font-bold text-slate-800 text-sm">
                                            <?php echo e($item->jenis_transaksi == 'masuk' ? 'Top Up Saldo' : ($item->nama_driver ?? 'Pengeluaran Umum')); ?>

                                        </div>
                                        <div class="text-[10px] font-black uppercase tracking-wider flex items-center gap-2 mt-0.5">
                                            <?php if($item->jenis_transaksi == 'masuk'): ?>
                                                <span class="text-emerald-500"><?php echo e($item->keterangan); ?></span>
                                            <?php else: ?>
                                                <span class="text-indigo-500"><?php echo e(str_replace('_', ' ', $item->jenis_penarikan)); ?></span>
                                                <?php if($item->no_kendaraan): ?> 
                                                    <span class="text-slate-300">•</span> 
                                                    <span class="text-slate-500"><?php echo e($item->no_kendaraan); ?></span> 
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <?php if($item->jenis_transaksi == 'masuk'): ?>
                                        <span class="font-bold text-emerald-600 text-sm">+ Rp <?php echo e(number_format($item->jumlah, 0, ',', '.')); ?></span>
                                    <?php else: ?>
                                        <span class="font-bold text-rose-600 text-sm">- Rp <?php echo e(number_format($item->jumlah, 0, ',', '.')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold <?php echo e($item->jenis_transaksi == 'masuk' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-blue-50 text-blue-600 border-blue-100'); ?> border uppercase">
                                        <?php echo e($item->status ?? 'Verified'); ?>

                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <?php if(!request('bulan')): ?>
                                            <a href="<?php echo e(route('admin.keuangan.cetak-struk', $item->id)); ?>" target="_blank" title="Cetak Struk" class="w-10 h-10 flex items-center justify-center bg-indigo-100 text-indigo-600 hover:bg-indigo-200 rounded-xl transition-colors shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                </svg>
                                            </a>

                                            <form action="<?php echo e(route('admin.keuangan.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini?');" class="m-0 inline-flex">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" title="Hapus Data" class="w-10 h-10 flex items-center justify-center bg-red-100 text-red-600 hover:bg-red-200 rounded-xl transition-colors shadow-sm cursor-pointer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 font-bold italic">Archived</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="font-bold text-gray-400">Belum ada riwayat aktivitas.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($riwayat->hasPages()): ?>
                <div class="px-8 py-4 bg-gray-50">
                    <?php echo e($riwayat->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Logika Pop-up Sukses setelah Berhasil Arsip
        <?php if(session('success')): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: "<?php echo e(session('success')); ?>",
                icon: 'success',
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'Oke'
            });
        <?php endif; ?>

        // 2. Logika Pop-up Error
        <?php if(session('error')): ?>
            Swal.fire({
                title: 'Gagal!',
                text: "<?php echo e(session('error')); ?>",
                icon: 'error',
                confirmButtonColor: '#e11d48',
                confirmButtonText: 'Tutup'
            });
        <?php endif; ?>

        // 3. Konfirmasi SweetAlert sebelum Tutup Buku
        function confirmArsip() {
            Swal.fire({
                title: 'Konfirmasi Tutup Buku',
                text: "Semua transaksi aktif akan dipindahkan ke ARSIP dan tabel utama akan dikosongkan. Apakah Anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tutup Buku!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formArsip').submit();
                }
            });
        }
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
<?php endif; ?><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/admin/keuangan/index.blade.php ENDPATH**/ ?>