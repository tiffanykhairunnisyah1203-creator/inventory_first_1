<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans min-h-screen">

    <div class="flex flex-col min-h-screen">
        
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 lg:px-12 sticky top-0 z-10">
            <h2 class="text-xl font-bold text-gray-800">Profil Saya</h2>
            <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </header>

        <main class="flex-1 py-8 px-4 sm:px-6 lg:px-12 overflow-y-auto">
            <div class="max-w-5xl mx-auto space-y-6"> 

                
                <?php if(session('sukses')): ?>
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-lg flex items-center shadow-sm" role="alert">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <div>
                            <p class="font-semibold">Berhasil Disimpan!</p>
                            <p class="text-sm"><?php echo e(session('sukses')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                
                
                <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
                    <div class="p-6 sm:p-10">
                        <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>

            </div>
        </main>

    </div>

</body>
</html><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/profile/edit.blade.php ENDPATH**/ ?>