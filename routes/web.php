<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManajemenAdminController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RiwayatStokController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KendaraanController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Depan - Langsung diarahkan ke Login
Route::get('/', [AuthController::class, 'showLogin'])->middleware('guest');

/*
|--------------------------------------------------------------------------
| 1. AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 2. DASHBOARD REDIRECTOR (PENENTU HALAMAN SETELAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'superadmin') {
        // Superadmin langsung ke Manajemen Barang
        return redirect()->route('barang.index');
    } elseif ($role === 'admin_keuangan') {
        return redirect()->route('admin.keuangan.index');
    }

    // Default untuk admin_gudang
    return redirect()->route('jenis.index');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| 3. AUTHENTICATED USER ROUTES (SEMUA ROLE YG SUDAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Khusus Superadmin: Kelola User Admin Lainnya
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('admin/kelola-admin', ManajemenAdminController::class);
    });
});

/*
|--------------------------------------------------------------------------
| 4. ADMIN ROUTES (GUDANG & KEUANGAN)
|--------------------------------------------------------------------------
*/

// --- AKSES GUDANG (Admin Gudang & Superadmin) ---
Route::middleware(['auth', 'role:admin_gudang,superadmin'])->group(function () {
    
    //  Jenis / support
    Route::prefix('admin/jenis')->name('jenis.')->group(function () {
        Route::get('/', [App\Http\Controllers\JenisController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\JenisController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\JenisController::class, 'store'])->name('store');
        Route::get('/{jenis}/edit', [App\Http\Controllers\JenisController::class, 'edit'])->name('edit');
        Route::put('/{jenis}', [App\Http\Controllers\JenisController::class, 'update'])->name('update');
    });

// data barang
    Route::prefix('admin/barang')->name('barang.')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        
        // Route Riwayat
        Route::get('/riwayat/{item_no}', [RiwayatStokController::class, 'show'])->name('riwayat');

        // Route Order & Packing
        Route::get('/order', [BarangController::class, 'createOrder'])->name('createOrder');
        Route::post('/order', [BarangController::class, 'storeOrder'])->name('storeOrder');
        
        Route::get('/packing', [BarangController::class, 'createPacking'])->name('createPacking');
        Route::post('/packing', [BarangController::class, 'storePacking'])->name('storePacking');

        // Route default
        Route::get('/create', [BarangController::class, 'create'])->name('create');
        Route::post('/', [BarangController::class, 'store'])->name('store');
        Route::get('/{barang}/edit', [BarangController::class, 'edit'])->name('edit');
        Route::put('/{barang}', [BarangController::class, 'update'])->name('update');
        Route::delete('/{barang}', [BarangController::class, 'destroy'])->name('destroy');
        Route::get('/get-stok', [BarangController::class, 'getStok'])->name('getstok');
    });
}); 


// --- AKSES KEUANGAN (Admin Keuangan & Superadmin) ---
Route::middleware(['auth', 'role:admin_keuangan,superadmin'])->group(function () {
    Route::prefix('admin/keuangan')->name('admin.keuangan.')->group(function () {
        Route::get('/', [KeuanganController::class, 'index'])->name('index');
        
        // Top Up
        Route::get('/topup', [KeuanganController::class, 'createTopup'])->name('topup');
        Route::post('/topup', [KeuanganController::class, 'storeTopup'])->name('store_topup');
        
        // Pencairan
        Route::get('/pencairan', [KeuanganController::class, 'createPencairan'])->name('pencairan');
        Route::post('/pencairan', [KeuanganController::class, 'store'])->name('store'); 
        Route::post('/pencairan/simpan', [KeuanganController::class, 'store'])->name('store_pencairan');
        
        // Arsip / Tutup Buku
        Route::post('/arsip', [KeuanganController::class, 'arsipData'])->name('arsip');
        
        // Hapus Arsip Bulan (Tambahan Baru)
        Route::delete('/arsip/{periode}/hapus', [KeuanganController::class, 'destroyArsipBulan'])->name('destroyArsip');
        
        // Cetak
        Route::get('/cetak-struk/{id}', [KeuanganController::class, 'cetakStruk'])->name('cetak-struk');

        // Route untuk AJAX tambah & hapus kendaraan
        Route::post('/kendaraan/store-ajax', [KendaraanController::class, 'storeAjax'])->name('kendaraan.storeAjax');
        Route::delete('/kendaraan/destroy-ajax/{no_plat}', [KendaraanController::class, 'destroyAjax'])->name('kendaraan.destroyAjax');

        // Wildcard (Delete by ID) diletakkan paling bawah agar tidak bentrok dengan route lain
        Route::delete('/{id}', [KeuanganController::class, 'destroy'])->name('destroy');
    });
});