<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- Tombol CReate --}}
            <a href="{{ route('kelola-admin.create') }}" 
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Admin
            </a>
        </div>
    </x-slot>

    <x-notif-popup />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    {{-- Tabel Responsif --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="border-b font-medium bg-gray-50 text-gray-500 uppercase tracking-wider">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nama</th>
                                    <th scope="col" class="px-6 py-4">Jabatan</th>
                                    <th scope="col" class="px-6 py-4">Email</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daftarAdmin as $admin)
                                <tr class="border-b transition duration-300 ease-in-out hover:bg-gray-50">
                                   <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="font-medium text-gray-900">{{ $admin->name }}</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $admin->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($admin->role) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">{{ $admin->email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('kelola-admin.edit', $admin->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                Edit
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('kelola-admin.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-10 text-gray-400">
                                        Belum ada data admin.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $daftarAdmin->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>