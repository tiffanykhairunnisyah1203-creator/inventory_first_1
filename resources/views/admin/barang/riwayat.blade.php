<x-admin-layout>
    <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800">Riwayat Stok Barang</h2>
            <p class="text-sm text-gray-500 mt-1">Item No: <span class="font-bold text-indigo-600">{{ $item_no }}</span></p>
        </div>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('barang.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-200 transition duration-150 ease-in-out border border-gray-300">
                &larr; Kembali
            </a>
        </div>
    </div>

    @if(session('sukses'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            {{ session('sukses') }}
        </div>
    @endif

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
                    @forelse($logs as $log)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($log->jenis == 'awal')
                                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold uppercase">Awal</span>
                            @elseif($log->jenis == 'order')
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-semibold uppercase">Order (Masuk)</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-semibold uppercase">Packing (Keluar)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-gray-800">
                            {{ $log->jumlah }}
                        </td>
                        <td class="px-6 py-4 text-center text-gray-600">
                            {{ $log->stok_sebelum }}
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-indigo-600">
                            {{ $log->stok_sesudah }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-400">Belum ada riwayat transaksi untuk barang ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>