<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ManajemenAdminController extends Controller
{
    public function index()
    {
        $daftarAdmin = User::where('role', 'admin')->latest()->paginate(10);

        return view('admin.kelola_admin.index', compact('daftarAdmin'));
    }

    /**
     * Menampilkan form create admin
     */
    public function create()
    {
        return view('admin.kelola_admin.create');
    }

    /**
     * Menyimpan data admin baru ke database 
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin_gudang,admin_keuangan,superadmin'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Kembali ke halaman list dan muncul pesan sukses
        return redirect()->route('kelola-admin.index')->with('sukses', 'Admin berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit
     */
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.kelola_admin.edit', compact('admin'));
    }

    /**
     * Memperbarui data di database 
     */
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$admin->id],
            'role' => ['required', 'in:admin_gudang,admin_keuangan,superadmin'],
            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $admin->update($dataToUpdate);

        return redirect()->route('kelola-admin.index')->with('sukses', 'Data admin berhasil diperbarui!');
    }

    /**
     * Menghapus admin atau DELETE
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('kelola-admin.index')->with('sukses', 'Admin berhasil dihapus!');
    }
}
