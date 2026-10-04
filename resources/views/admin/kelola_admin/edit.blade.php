<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Admin') }}
            </h2>
            <a href="{{ route('kelola-admin.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm font-medium">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
                            <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil akun, alamat email, dan foto profil.</p>
                        </header>

                        <form method="post" action="{{ route('kelola-admin.update', $admin->id) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama</label>
                                <input id="name" name="name" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" value="{{ old('name', $admin->name) }}" required autocomplete="name" />
                                @error('name') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                                <input id="email" name="email" type="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" value="{{ old('email', $admin->email) }}" required autocomplete="username" />
                                @error('email') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="role" class="block font-medium text-sm text-gray-700">Jabatan / Role</label>
                                <select id="role" name="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    SIMPAN
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>
                            <p class="mt-1 text-sm text-gray-600">Pastikan akun menggunakan password yang panjang dan acak agar tetap aman.</p>
                        </header>

                        <form method="post" action="{{ route('kelola-admin.update', $admin->id) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                            
                            <input type="hidden" name="name" value="{{ $admin->name }}">
                            <input type="hidden" name="email" value="{{ $admin->email }}">
                            <input type="hidden" name="role" value="{{ $admin->role }}">

                            <div>
                                <label for="password" class="block font-medium text-sm text-gray-700">Password Baru</label>
                                <input id="password" name="password" type="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" autocomplete="new-password" />
                                @error('password') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" autocomplete="new-password" />
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    SAVE
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>
                            <p class="mt-1 text-sm text-gray-600">Setelah akun dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
                        </header>

                        <form method="post" action="{{ route('kelola-admin.destroy', $admin->id) }}" class="p-6">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                DELETE ACCOUNT
                            </button>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>