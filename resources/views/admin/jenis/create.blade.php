<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Jenis Baru</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-lg">
                <form action="{{ route('jenis.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Item No</label>
                        <input type="text" name="item_no" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500" required placeholder="">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Item Description</label>
                        <input type="text" name="item_description" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500" required placeholder="">
                    </div>

                    <div class="flex justify-end gap-2 mt-8 pt-4 border-t border-gray-100">
                        <a href="{{ route('jenis.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-sm">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md font-semibold text-sm">Simpan Item Baru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>