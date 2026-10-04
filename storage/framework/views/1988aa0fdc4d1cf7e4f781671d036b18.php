<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">MASUK SISTEM</h2>

        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('login')); ?>" method="POST">
            <?php echo csrf_field(); ?> <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Username</label>
                <input type="username" name="username" value="<?php echo e(old('username')); ?>" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none" 
                    placeholder="Masukkan username">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none" 
                    placeholder="Masukkan password">
            </div>

            <button type="submit" 
                class="w-full bg-indigo-600 text-white py-2 rounded-lg font-bold hover:bg-indigo-700 transition duration-200">
                Login
            </button>
        </form>
        
        <p class="mt-4 text-center text-xs text-gray-400 italic">
            Hubungi IT Support jika lupa password.
        </p>
    </div>
</body>
</html><?php /**PATH C:\Project_Laravel10\Gudang\Gudang\Gudang\resources\views/auth/login.blade.php ENDPATH**/ ?>